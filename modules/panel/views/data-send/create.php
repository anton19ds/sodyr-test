<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DataSend $model */

$this->title = 'Create Data Send';
$this->params['breadcrumbs'][] = ['label' => 'Data Sends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-send-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
