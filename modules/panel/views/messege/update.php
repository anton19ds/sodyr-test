<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Messege $model */

$this->title = 'Update Messege: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Messeges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="messege-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
