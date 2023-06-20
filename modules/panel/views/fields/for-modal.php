<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Templates $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="templates-form">

  <?php $form = ActiveForm::begin(); ?>
  <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
  <div class="row">
    <div class="col-md-12 mt-3">
      <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-8 mt-3">
      <label for="">Шаблон</label>
      <?= Html::textarea("Templates[template]", (!empty($model->template) ? json_decode($model->template) : ''),['class'=>'form-control', 'rows' => 6, 'id' => 'template_fil'] )?>
      <?//= $form->field($model, 'template')->textarea(['rows' => 6, 'id' => 'template_fil']) ?>
    </div>

    <div class="col-md-4 mt-3">
      <? $array = ArrayHelper::map($field, 'id', 'name')?>
      <label for="">Поля  </label>
      <select name="field" id="field" class="form-control">
        <? foreach($array as $rty => $item):?>
          <option value="<?= $rty?>"><?= $item?></option>
          <? endforeach;?>
      </select>
    </div>
    
    <div class="col-md-12 mt-3">
      <div class="form-group">
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-success saveThis']) ?>
      </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>

</div>