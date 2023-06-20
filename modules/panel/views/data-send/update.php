<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataSend $model */

$this->title = 'Update Data Send: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Sends', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-send-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
