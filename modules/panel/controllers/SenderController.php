<?php

namespace app\modules\panel\controllers;

use app\models\DataSend;
use app\models\Messege;
use app\models\Templates;
use app\widgets\LookRende;
use app\widgets\ViewRende;
use yii\web\Controller;

class SenderController extends MainController
{
  public function actionIndex($id, $template)
  {
    $modelMessege = Messege::find()->where(['id' => $id])->one();
    $templates = Templates::find()->where(['id' => $template])->one();

    if (!empty($modelMessege) && !empty($templates)) {
      $viter = LookRende::widget(['templates' => $templates, 'messege' => $modelMessege]);
      $param = nl2br($viter);
      $str = trim(preg_replace('/(\r\n|\n)+(?=(\r\n|\n){2,})/u', '', $viter));
      return $this->render('view', [
        'id' => $id,
        'template' => $template,
        'viter' => nl2br($str)
      ]);
    }
  }
  public function actionTestSends($template, $id)
  {
    $modelMessege = Messege::find()->where(['id' => $id])->one();
    $templates = Templates::find()->where(['id' => $template])->one();
    $innert =  ViewRende::widget(['templates' => $templates, 'messege' => $modelMessege]);
    if (mb_stripos($innert, 'ok') !== false) {
      return 'Сообщение отправлено';
    }else{
      return 'Ошибка отправки';
    }
    
  }



  public function actionSend()
  {
    $modelMessege = Messege::find()->where(['statys' => 'nosend'])->all();
    $templates = Templates::find()->where(['statys' => '1'])->all();
    if (!empty($modelMessege) && !empty($templates)) {
      foreach ($modelMessege as $item) {
        foreach ($templates as $template) {
          $innert =  ViewRende::widget(['templates' => $template, 'messege' => $item]);
          $array = json_decode($innert, true);
          $model = new DataSend([
            'messege_id' => $item->id,
            'bot_id' => $template->bot_id,
            'template_id' => $template->id
          ]);
          if (isset($array['ok']) && !empty($array['result'])) {
            $model->data = $innert;
          } else {
            $model->data = 'Ошибка отправки';
          }
          if (!$model->save()) {
            return var_dump($model->getErrors());
          };
        }

        $item->statys = 'send';
        if(!$item->save()){
          return var_dump($item->getErrors());
        };
      }
    }
  }
}
