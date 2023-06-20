<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Messege $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Messeges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="messege-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
      ],
    ]) ?>
  </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      // 'id',
      'text:ntext',
      // 'date',
      // 'update_id',
      // 'messege_id',
    ],
  ]) ?>

</div>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12">
      <pre>
        <?php print_r($fields)?>
        </pre>
        <? $text = $model->text;?>
        <?php foreach ($fields as $item) {
           $perem1 =  $item['before_param'];
           $perem2 =  $item['after_param'];

           $block1 = stristr($text, $perem2, true);
           //echo stristr($text, $perem1); // PHP script
           $block2 = stristr($block1, $perem1);
           $result = str_replace($perem1, '', $block2);
           //echo "<pre>";
           $a = nl2br($result);
           echo $a;
           
           //echo "</pre>";
        }?>
        <br>
        <?//= $text;?>
    </div>
  </div>
</div>