<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TelegramBot $model */

$this->title = 'Update Telegram Bot: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Telegram Bots', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="telegram-bot-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
