<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Templates $model */

$this->title = 'Шаблон: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'обнавление';
?>
<div class="templates-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Отменить','',['class' => 'btn btn-warning', 'onclick' => 'location.reload();'])?>
    <?= $this->render('_form', [
        'model' => $model,
        'field' => $field,
        'tg' => $tg,
        'setr' => $setr,
        'arrayEm' => $arrayEm,
        'param' => $param
    ]) ?>
</div>
