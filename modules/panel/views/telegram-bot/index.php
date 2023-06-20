<?php

use app\models\TelegramBot;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Настройка ботов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-bot-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-secondary" role="alert">
    В данном разделе можно настроить путь отправки сообщений после прохождения через параметры шаблона. Здесь мы указываем бока который будет заниматься отправкой сообщений и данные о сообществе, в которое бот должен будет направить полученные сообщения исходя из настроек шаблонов.
Инструкции о том как создавать боты и сообщества, а также узнавать данные о них можно найти по ссылке:  <a href="https://disk.yandex.ru/d/CEYGAXnycukuWA">Инструкция</a>
  </div>
    <p>
        <?= Html::a('Добавить бота', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
              'attribute' => 'name',
              'format' => 'raw',
              'value' => function($model){
                return '<a href="/panel/telegram-bot/view?id='.$model->id.'">'.$model->name.'</a>';
              }
            ],
            'bot_id',
            'chat_id',
            ['attribute' => 'date', 'format' => ['date', 'php:Y-m-d H:i']],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TelegramBot $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template'=>'{update}',
            ],
            [
              'class' => ActionColumn::className(),
              'urlCreator' => function ($action, TelegramBot $model, $key, $index, $column) {
                  return Url::toRoute([$action, 'id' => $model->id]);
               },
               'template'=>'{delete}',
          ],
        ],
    ]); ?>
</div>
