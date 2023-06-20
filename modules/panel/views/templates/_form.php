<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Templates $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="alert alert-secondary mt-3" role="alert">
  В данном пункте можно задать условия для отработки шаблона.
  Здесь можно задать значение, на которое будет ориентироваться система при определении подходит ли присланное сообщение данному шаблону или нет.
  Например: Светлый
  Система считает это условие как: “Отправлять эти сообщения по данному шаблону в Телеграмм чат “Название чата” если оно содержит “Светлый”.
</div>
<div class="templates-form">

  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-md-12 mt-3">
      <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
    </div>

    <div class="col-md-8 mt-3">
      <label for="">Шаблон</label>
      <?php $template =  ($model->template ? json_decode($model->template) : ''); ?>
      <div class="btn-toolbar mb-3">
        <a href="" class='styleB re-bold btn btn-outline-secondary'>b</a>
        <a href="" class='styleB re-ital btn btn-outline-secondary'>i</a>
        <a href="" class='styleB re-seld btn btn-outline-secondary'>s</a>
        <a href="" class='styleB re-under btn btn-outline-secondary'>u</a>
      </div>


      <!-- <div id="pole" contenteditable="true"><? //= $template
                                                  ?></div> -->
      <?= Html::textarea("Templates[template]", (!empty($model->template) ? json_decode($model->template) : ''), ['class' => 'form-control', 'rows' => 15, 'id' => 'areaS']); ?>


    </div>

    <div class="col-md-4 mt-3">
      <?php $array = ArrayHelper::map($field, 'id', 'name'); ?>
      <label for="">Поля </label>
      <select name="field" id="field" class="form-control">
        <option value="0">Выберите переменную</option>
        <?php foreach ($array as $rty => $item): ?>
          <?php if($rty):?>
          <option value="<?= $rty; ?>"><?= $item; ?></option>
          <?php endif;?>
        <?php endforeach; ?>
      </select>

      <input type="text" class="form-control mt-2" id='pervods' placeholder="Текст для вставки">
      <input type="text" class="form-control mt-2" id='idField'>
      <a href="" class='root-shot btn btn-info mt-2'>Добавить</a>
      <div class="row">
        <div class="col-md-12 mt-3">
          <div class="row">

            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button style="background:#ddd" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    "Эмодзи"
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="row">
                    <?php foreach ($arrayEm as $key => $item) : ?>
                      <div class="col-md-1">
                        <div class="card-body itemEm" style="cursor:pointer" data-key="<?= $key ?>" data-item="<?= $item ?>">
                          <?= $key; ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 mt-3">
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-secondary mt-3" role="alert">
            Здесь можно использовать параметры условия “и”.
            Например: 3 года
            Система считает это условие как: Отправлять эти сообщения по данному шаблону в Телеграмм чат “Название чата”, если оно содержит “Светлый” и “3 года”.
          </div>
          <div class="alert alert-secondary mt-3" role="alert">
            Здесь можно использовать параметры условия “или”.
            Например: Калининград
            Система считает это условие как: Отправлять эти сообщения по данному шаблону в Телеграмм чат “Название чата”, если оно содержит “Светлый” или “Калининград”.
          </div>
        </div>
        <div class="col-md-12">
          <label>Параметры ключей</label>
        </div>
        <div class="col-md-10">
          <input type="text" class="form-control" value="<?= (isset($setr) && $setr ? $setr : ''); ?>" readonly="" disabled="">
          <?php if (isset($param) && !empty($param)) : ?>
            <div class="col-md-6">
              <input type="hidden" value="<?= count($param) ?>" class="array_param">
              <div class="row ester">
                <?php foreach ($param as $key => $val) : ?>
                  <?php if (!empty($val)) : ?>
                    <div class="row chor_<?= $key ?> sevort">
                      <?php foreach ($val as $let => $ger) : ?>
                        <?php if (!empty($ger)) : ?>
                          <input type="hidden" value="<?= count($val); ?>" class="count_param_<?= $key; ?>">
                          <div class="col-md-8 mt-2 stroks_<?= $key; ?><?= $let; ?>">
                            <input type="text" class="form-control" name="Parametr[<?= $key; ?>][<?= $let; ?>]" value="<?= $ger; ?>">
                          </div>
                          <div class="col-md-1 mt-2 stroks_<?= $key; ?><?= $let; ?>">
                            <?= Html::submitButton('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>', ['class' => 'btn btn-warning delser-block', 'data-zet' => $key . $let]); ?>
                          </div>

                        <?php endif; ?>
                      <?php endforeach; ?>
                      <div class="col-md-12 mt-3">
                        <?= Html::submitButton('+ Добавить условие "И"', ['class' => 'btn btn-info add-param', 'data-is' => $key]); ?>
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="col-md-12 mt-3">
              <?= Html::submitButton('+ Добавить условие "ИЛИ"', ['class' => 'btn btn-info or-param']); ?>
            </div>
          <?php else : ?>
            <div class="col-md-6">
              <input type="hidden" value="0" class="array_param">
              <div class="row ester">
              </div>
            </div>
            <div class="col-md-12 mt-3">
              <?= Html::submitButton('+ Добавить условие "ИЛИ"', ['class' => 'btn btn-info or-param']); ?>
            </div>

          <?php endif; ?>
        </div>


      </div>
    </div>
    <div class="col-md-12 mt-3">
      <?= $form->field($model, 'statys')->checkbox(['value' => '1']); ?>
    </div>
    <div class="col-md-12 mt-3">
      <?= $form->field($model, 'bot_id')->dropDownList(ArrayHelper::map($tg, 'id', 'name'), ['prompt' => 'Выберите бота...'], ['class' => 'form-control']); ?>
    </div>
    <div class="col-md-12 mt-3">
      <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
      </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>