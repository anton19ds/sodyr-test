<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Messege $model */

$this->title = 'Create Messege';
$this->params['breadcrumbs'][] = ['label' => 'Messeges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messege-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
