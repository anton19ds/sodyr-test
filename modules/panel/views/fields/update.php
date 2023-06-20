<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Fields $model */

$this->title = 'Изменить поля: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Переменные', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="fields-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'reserv' => $reserv
    ]) ?>

</div>
