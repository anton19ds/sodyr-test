<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TelegramBot $model */

$this->title = 'Добаление бота';
$this->params['breadcrumbs'][] = ['label' => 'Список ботов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-bot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
