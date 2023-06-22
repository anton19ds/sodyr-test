<?php

use app\models\Templates;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Templates $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="templates-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date:date',
            'name',
            [
              'attribute' => 'template',
              'format' => 'raw',
              'value' => function(Templates $model){
                return nl2br(json_decode($model->template));
              }
            ],
            [
              'attribute' => 'bot_id',
              'value' => function(Templates $model){
                return $model->bot->name;
              }
            ]
            // 'param',
        ],
    ]) ?>

</div>
<div class="row">
  <div class="col-md-12">
  <div class="alert alert-secondary mt-2 mb-2" role="alert">
  Здесь вы сможете посмотреть в каком виде сообщение отправится пользователям в телеграмм канал, для этого нужно будет выбрать какое-то сообщение из базы данных, оно отобразится с учетом настроек шаблона в новом окне.
  </div>
    <label for="">Просмотреть</label>
    <?= Html::dropDownList('sdfer','',['' => 'Выбрать сообщение...','сообщения' => ArrayHelper::map($messege, 'id', 'id')],['class' => 'form-control', 'id' => 'viewSender', 'data-template' => $model->id])?>
  
  </div>
  
</div>

