<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Templates;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TelegramBot $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Telegram Bots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="telegram-bot-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
      ],
    ]) ?>
  </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'bot_id',
      'chat_id',
      'date:date',
      'name',
    ],
  ]) ?>

  <h2 class="mt-5">Шаблоны бота</h2>
  <div class="templates-index">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'columns' => [

        'id',
        'date:date',
        
        
        [
          'attribute' => 'name',
          'format' => 'raw',
          'value' => function($model){
            return '<a href="/panel/templates/view?id='.$model->id.'">'.$model->name.'</a>';
          }
        ],
        // 'template:ntext',
        [
          'attribute' => 'bot_id',
          'value' => function ($model) {
            $bot = $model->bot;
            return $bot->name;
          }
        ],
        [
          'attribute' => 'statys',
          'format' => 'raw',
          'value' => function (Templates $model) {
            if ($model->statys == '1') {
              return "<span class=\"badge bg-success\">Включен</span>";
            } else {
              return "<span class=\"badge bg-danger\">Отключен</span>";
            }
          }
        ],
      ],
    ]); ?>


  </div>


</div>