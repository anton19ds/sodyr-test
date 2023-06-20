<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TelegramBot $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="telegram-bot-form">

  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <?= $form->field($model, 'bot_id')->textInput(['maxlength' => true]) ?>

    <sub class='mt-2'>
      Бот ID идентификационный номер конкретного используемого бота который отправляет сообщения в нужный чат.
      Как узнать Бот ID можно прочитать здесь: <a href="https://disk.yandex.ru/i/u5e84Rv96dbWJg">Инструкция</a>
    </sub>
    <div class="col-md-12 mt-3">
      <?= $form->field($model, 'chat_id')->textInput(['maxlength' => true]) ?>
      <sub class='mt-2'>
        Чат ID идентификационный номер конкретного чата, в который должны будут попадать сообщения от бота.
        Как узнать Бот ID можно прочитать здесь: <a href="https://disk.yandex.ru/i/3CZ29h1GyMGj4Q">Инструкция</a>
      </sub>
    </div>

    <div class="col-md-12 mt-3">
      <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12 mt-3">
      <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>

</div>