<?php

use yii\helpers\Html;

$this->title = 'Просмотр';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
  <div class="col-md-12 mb-3">
    <?= Html::a('! Тестовая отправка', ['/panel/sender/test-sends', 'template' => $template, 'id' => $id], ['class' => 'btn btn-success']) ?>
  </div>

</div>
<div class="back">
  <div class="content-tg">
    <div class="row">

      <div class="col-md-12">
        <? if (!empty($viter)) : ?>
          
          <?= htmlspecialchars_decode($viter)?>
        <? else : ?>
          Не подходят условия
        <? endif; ?>
      </div>

      
    </div>
  </div>
</div>