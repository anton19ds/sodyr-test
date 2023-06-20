<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Templates $model */

$this->title = 'Новый шаблон';
$this->params['breadcrumbs'][] = ['label' => 'шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'tg' => $tg,
    'field' => $field,
    'model' => $model,
    'arrayEm' => $arrayEm
  ]) ?>

</div>