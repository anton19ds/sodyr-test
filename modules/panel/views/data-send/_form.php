<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DataSend $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-send-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'messege_id')->textInput() ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bot_id')->textInput() ?>

    <?= $form->field($model, 'template_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
