<?php

use app\models\Messege;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messege-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <!-- <p>
        <? //  = Html::a('Create Messege', ['create'], ['class' => 'btn btn-success']) 
        ?>
    </p> -->
  <div class="alert alert-secondary" role="alert">
    Данный раздел предназначен для отслеживания поступлений новых сообщений в базу данных, а также отслеживание статуса их переотправки согласно заданного шаблона в нужные телеграмм-сообщества.
  </div>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      'id',
      'text:ntext',
      'date:date',
      'update_id',
      'messege_id',
      'statys',
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Messege $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        },
        'template' => '{update}'
      ],
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Messege $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        },
        'template' => '{view}'
      ],
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Messege $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        },
        'template' => '{delete}'

      ],
    ],
  ]); ?>
</div>