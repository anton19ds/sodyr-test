<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Fields $model */

$this->title = 'Добавить переменные';
$this->params['breadcrumbs'][] = ['label' => 'Переменные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fields-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
