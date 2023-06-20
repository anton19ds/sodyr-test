<?php

use app\models\Fields;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Fields $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Переменные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fields-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'date:date',
            [
              'attribute' => 'data',
              'format' => 'raw',  
              'value' => function(Fields $model){
                $reserv = json_decode($model->data, true);
                $str = '<ul>';
                foreach($reserv as $key => $item){
                  $str .= "<li>";
                  $str .= $item['before_param']."<br>";
                  $str .= $item['after_param'];
                  $str .= "</li>";
                  $str .= "<li style=\"list-style-type: none;\"></li>";
                }
                $str .= '</ul>';
                return $str;
              }
            ],
        ],
    ]) ?>

</div>
