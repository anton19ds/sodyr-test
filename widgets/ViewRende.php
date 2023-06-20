<?php

namespace app\widgets;

use app\models\Fields as ModelsFields;
use app\models\Templates;
use Yii;
use yii\base\Widget;
use yii\httpclient\Client;

class ViewRende extends Widget
{
  public $templates;
  public $messege;
  public function run()
  {
    $bot = $this->templates->bot;
    $result = $this->parse(json_decode($this->templates->template));
    $param = json_decode($this->templates->param, true);
    //print_r($param);
    if (!empty($param)) {
      $statys = array();
    }else{
      return $this->sendMesseges($result, $bot->bot_id, $bot->chat_id);
    }
    foreach ($param as $key => $item) {
      
      foreach ($item as $el => $val) {
        
        if ($result && $val && mb_stripos($result, $val) !== false) {
          $statys[$key][] = 1;
        } else {
          $statys[$key][] = 0;
        }
      }
    }
    print_r($statys);
    $resutl = array();
    foreach ($statys as $er => $var) {
      if (in_array(0, $var)) {
        $resutl[] = 0;
      } else {
        $resutl[] = 1;
      }
    }
    if(in_array(1,$resutl)){
      return $this->sendMesseges($result, $bot->bot_id, $bot->chat_id);
    }
    
  }


  public function sendMesseges($result, $bot_id, $chat_id)
  {
    $str = trim(preg_replace('/(\r\n|\n)+(?=(\r\n|\n){2,})/u', '', $result));   
    $apiToken = $bot_id;
    $data = [
      'chat_id' => $chat_id,
      'text' => $str,
      'parse_mode' => 'html'
    ];
  $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));
  return $response;
  }


  public function parse($content)
  {
    $result = $content;
    $shortcodes = $this->getShortcodeList($content);
    foreach ($shortcodes as $shortcode) {
      // Only process known/supported shortcodes
      if (in_array($shortcode, ['fields'])) {
        $regexp = $this->getShortcodeRegexp($shortcode);
        $result = preg_replace_callback("/$regexp/s", array($this, 'parseSingle'), $result);
      }
      if (!empty($result)) {
        return $result;
      }else{
        continue;
      }
    }
  }

  /**
   * Parse single shortcode
   * 
   * Borrowed from WordPress wp/wp-includes/shortcode.php
   * 
   * @param array $m Shortcode matches
   * @return string
   */
  protected function parseSingle($m)
  {
    $attr = $this->shortcodeParseAtts($m[3]);
    $fields = ModelsFields::find()->where(['id' => $attr['id']])->asArray()->one();
    $text = $this->messege->text;
    if (!empty($fields['data'])) {
      $param = json_decode($fields['data'], true);
      foreach ($param as $item) {
        $perem1 =  $item['before_param'];
        $perem2 =  $item['after_param'];
        if ($perem2 == 'end fields') {
          $block1 = strip_tags(trim(stristr($text, $perem1)));
          $result = trim(str_replace($perem1, ' ', $block1));
        } else {
          $block1 = strip_tags(trim(stristr($text, $perem2, true)));
          $block2 = strip_tags(trim(stristr($block1, $perem1)));
          $result = trim(str_replace($perem1, ' ', $block2));
        }

        if (!empty($result) && strlen($result) != 0) {
          if (isset($attr["palseholder"]) && !empty($attr["palseholder"])) {
            $palseholder = trim(str_replace("_", " ", $attr["palseholder"]));
            return $palseholder . " " . $result;
          } else {
            return trim($result);
          }
        }else{
          continue;
        }
      }
    }
  }

  /**
   * Get the list of all shortcodes found in given content
   * 
   * @param string $content Content to process
   * @return array
   */
  protected function getShortcodeList($content)
  {
    $result = array();

    preg_match_all("/\[([A-Za-z_]+[^\ \]]+)/", $content, $matches);
    if (!empty($matches[1])) {
      foreach ($matches[1] as $match) {
        $result[$match] = $match;
      }
    }
    return $result;
  }

  /**
   * Parses attributes from a shortcode
   * 
   * Borrowed from WordPress wp/wp-includes/shortcode.php
   * 
   * @param string $text
   * @return array
   */
  protected function shortcodeParseAtts($text)
  {
    $atts = array();
    $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
    $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
    if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
      foreach ($match as $m) {
        if (!empty($m[1]))
          $atts[strtolower($m[1])] = stripcslashes($m[2]);
        elseif (!empty($m[3]))
          $atts[strtolower($m[3])] = stripcslashes($m[4]);
        elseif (!empty($m[5]))
          $atts[strtolower($m[5])] = stripcslashes($m[6]);
        elseif (isset($m[7]) and strlen($m[7]))
          $atts[] = stripcslashes($m[7]);
        elseif (isset($m[8]))
          $atts[] = stripcslashes($m[8]);
      }
    } else {
      $atts = ltrim($text);
    }
    return $atts;
  }

  /**
   * Returns a regular expression for matching a shortcode tag
   * 
   * Borrowed from WordPress wp/wp-includes/shortcode.php
   * 
   * @return string
   */
  protected function getShortcodeRegexp($tagregexp)
  {

    return
      '\\['                              // Opening bracket
      . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
      . "($tagregexp)"                     // 2: Shortcode name
      . '(?![\\w-])'                       // Not followed by word character or hyphen
      . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
      . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
      . '(?:'
      . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
      . '[^\\]\\/]*'               // Not a closing bracket or forward slash
      . ')*?'
      . ')'
      . '(?:'
      . '(\\/)'                        // 4: Self closing tag ...
      . '\\]'                          // ... and closing bracket
      . '|'
      . '\\]'                          // Closing bracket
      . '(?:'
      . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
      . '[^\\[]*+'             // Not an opening bracket
      . '(?:'
      . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
      . '[^\\[]*+'         // Not an opening bracket
      . ')*+'
      . ')'
      . '\\[\\/\\2\\]'             // Closing shortcode tag
      . ')?'
      . ')'
      . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
  }
}

