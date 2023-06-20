<?php

use yii\bootstrap5\Html;

?>
<div class="col-md-8 mt-2 stroks_<?= $is ?><?= $count ?>">
  <input type="text" class="form-control" name="Parametr[<?= $is ?>][<?= $count ?>]">
</div>
<div class="col-md-1 mt-2 stroks_<?= $is ?><?= $count ?>">
  <?= Html::submitButton('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>', ['class' => 'btn btn-warning delser-block', 'data-zet' =>$is.$count]) ?>
</div>
</div>