<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Fields $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fields-form">

  <?php $form = ActiveForm::begin(); ?>
  <input type="hidden" value="<?= (isset($reserv) && !empty($reserv) ? count($reserv) : '0') ?>" class="col_param">
  <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'plaseholder')->textInput() ?>
  <div class="col-md-12 mt-3">
    <label for="">Группа полей</label>
  </div>
  <?php if (is_array($reserv) && isset($reserv) && !empty($reserv)) : ?>
    <?php foreach ($reserv as $key => $item) : ?>
      <div class="col-md-12 mt-3 card">
        <div class="row">
          <div class="col-md-11">
            <div class="block_pole card-body">
              <label for="">Текст до переменной</label>
              <?= Html::textInput('Pole[' . $key . '][before_param]', $item['before_param'], ['class' => 'form-control', 'required' => 'true']); ?>
              <label for="">Текст после переменной</label>
              <?= Html::textInput('Pole[' . $key . '][after_param]', $item['after_param'], ['class' => 'form-control after',  'required' => 'true']); ?>
              <?= Html::a('Конец сообщения', '#', ['class' =>'fogot']);?>
            </div>
          </div>
          <div class="col-md-1 mt-3">
            <button type="button" class="btn btn-secondary delete-card">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
      <?php if (array_key_last($reserv) == $key) : ?>
        <div class="col-md-12 mt-3">
          <?= Html::submitButton('Добавить группу полей', ['id' => 'addGrupol', 'class' => 'btn btn-info']); ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php else : ?>
    <div class="col-md-12 mt-3 card">
      <div class="block_pole card-body">
        <label for="">Текст до переменной</label>
        <?= Html::textInput('Pole[0][before_param]', '', ['class' => 'form-control', 'required' => 'true']) ?>
        <label for="">Текст после переменной</label>
        <?= Html::textInput('Pole[0][after_param]', '', ['class' => 'form-control after',  'required' => 'true']) ?>
        <?= Html::a('Конец сообщения', '#', ['class' =>'fogot'])?>
        <br>
        <sub> Данная настройка устанавливается в случае, когда используемая переменная последняя в сообщении (после нее нет никакого текст и никаких данных).</sub>
      </div>
    </div>
    <div class="col-md-12 mt-3">
          <?= Html::submitButton('Добавить группу полей', ['id' => 'addGrupol', 'class' => 'btn btn-info']); ?>
        </div>
  <?php endif; ?>
  <div class="form-group mt-3">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
  </div>
  <?php ActiveForm::end(); ?>
</div>