<?php

use app\models\Templates;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Шаблоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <div class="alert alert-secondary" role="alert">
    В данном разделе можно настроить шаблоны отправки сообщений, указать необходимые настройки и путь отправки сообщений после обработки через шаблон.
    В текстовом редакторе можно вписать любые текстовые значения и использовать оригинальное оформление вакансии. После редактирования текста можно настроить в какое сообщество направлять сообщения по данному шаблону, а также указать параметры для фильтрации сообщений.

  </div>
  <p>
    <?= Html::a('Новый Шаблон', ['create'], ['class' => 'btn btn-success']) ?>
  </p>


  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      'id',
      'date:date',
      'updata:date',
      'name',
      // 'template:ntext',
      [
        'attribute' => 'bot_id',
        'value' => function ($model) {
          $bot = $model->bot;
          if(isset($bot->name)){
            return $bot->name;
            
          }
          
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
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Templates $model, $key, $index, $column) {
          return [$action, 'id' => $model->id];
        },
        'template' => '{update}'
      ],
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Templates $model, $key, $index, $column) {
          return [$action, 'id' => $model->id];
        },
        'template' => '{view}'
      ],
      [
        'attribute' => '',
        'format' => 'raw',
        'value' => function ($model) {
          return '<a href="/panel/templates/copy?id=' . $model->id . '">' . 'Копировать' . '</a>';
        }
      ],
      [
        'attribute' => '',
        'format' => 'raw',
        'value' => function ($model) {
          return '<a href="/panel/templates/delete?id=' . $model->id . '" title="Удалить" aria-label="Удалить" data-pjax="0" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post"><svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg></a>';
        }
      ],
    ],
  ]); ?>


</div>