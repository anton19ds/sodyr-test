<?php

namespace app\widgets;

use app\models\Fields as ModelsFields;
use Yii;
use yii\base\Widget;
class Fields extends Widget
{
  public $id = null;
  public $name = null;
  public $param = null;
  public function run()
  {
    //$model = ModelsFields::findOne($this->id);
    //echo "<pre>";
    //print_r($model);
    return 'Поле'.$this->id;

  }
}
