<?php

use app\models\Fields;
use app\models\Templates;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
$this->title = 'Перед удалением, Шаблоны которые необходимо изменить';

?>
<div class="templates-index">
<br>
    <h1><?= Html::encode($this->title) ?></h1>
<br>
<? Pjax::begin([
  'id' => 'modal-bord'
]) ?>
<?
echo GridView::widget([
  'dataProvider' => $dataProvider,
  'columns' => [
    'id',
    'date:date',
    'name',
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
    [
      'attribute' => '#',
      'format' => 'raw',
      'value' => function($model){
        return '<a href="#" class="sepModal" data-id="'.$model->id.'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16"><path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/></svg></a>';
      }
    ],
    
  ],
]);
?>
<? Pjax::end()?>
<?= Html::a('Удалить переменную', ['del-field', 'id' => $id], ['class' => 'btn btn-danger']) ?>
<? Modal::begin([
  'id' => 'form_modal',
  'size' => 'modal-lg'
])?>
<div id="form-modal-body">

</div>
<? Modal::end();?>
</div>