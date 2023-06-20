<?php

use app\models\Fields;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Переменные';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fields-index">

  <h1><?= Html::encode($this->title); ?></h1>
  <div class="alert alert-secondary" role="alert">
    Данный раздел предназначен для настроек параметров переменных, которые в последующем используются в шаблонах сообщений.
    Переменная определяется фиксированными значениями примерно идентичных сообщений, которые направляются в группу в телеграмме.
    В нашем случае переменными служат ключевые параметры вакансии, например: название вакансии, место работы, требования к кандидату и т.д.
    Чтобы правильно настроить переменную необходимо указать границы ее поиска для системы (текст до нужной переменной и текст после нее).

  </div>
  <p>
    <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']); ?>
  </p>


  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      'id',
      'name',
      'date:date',
      [
        'attribute' => 'data',
        'format' => 'raw',
        'value' => function (Fields $model) {
          $reserv = json_decode($model->data, true);
          if (!empty($reserv) && is_array($reserv)) {
            $str = '<ul>';
            foreach ($reserv as $key => $item) {
              $str .= "<li>";
              $str .= $item['before_param'] . "<br>";
              $str .= $item['after_param'];
              $str .= "</li>";
              $str .= "<li style=\"list-style-type: none;\"></li>";
            }
            $str .= '</ul>';
            return $str;
          } else {
            return null;
          }
        }
      ],

      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Fields $model, $key, $index, $column) {
          return [$action, 'id' => $model->id];
        },
        'template' => '{update}'
      ],
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Fields $model, $key, $index, $column) {
          return [$action, 'id' => $model->id];
        },
        'template' => '{view}'
      ],
      [
        'attribute' => '',
        'format' => 'raw',
        'value' => function ($model) {
          return '<a href="/panel/fields/delete?id=' . $model->id . '">Удалить</a>';
        }
      ],
    ],
  ]); ?>


</div>