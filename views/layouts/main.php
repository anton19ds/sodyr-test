<?php
/** @var yii\web\View $this */
/** @var string $content */
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
AppAsset::register($this);
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
  <?php $this->beginBody() ?>
  <header id="header">
    <?php
    NavBar::begin([
      'brandLabel' => Yii::$app->name,
      'brandUrl' => '/panel/messege',
      'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
      'options' => ['class' => 'navbar-nav'],
      'items' => [
        ['label' => 'Сообщения', 'url' => ['/panel/messege']],
        ['label' => 'Переменные', 'url' => ['/panel/fields']],
        ['label' => 'Боты', 'url' => ['/panel/telegram-bot']],
        ['label' => 'Шаблоны', 'url' => ['/panel/templates']],
        //['label' => 'Отправка', 'url' => ['/panel/sender']],
        ['label' => 'Logs', 'url' => ['/panel/data-send']],
        Yii::$app->user->isGuest
          ? ['label' => 'Login', 'url' => ['/site/login']]
          : '<li class="nav-item">'
          . Html::beginForm(['/site/logout'])
          . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'nav-link btn btn-link logout']
          )
          . Html::endForm()
          . '</li>'
      ]
    ]);
    NavBar::end();
    ?>
  </header>
  <main id="main" class="flex-shrink-0" role="main">
    <div class="container">
      <?php if (!empty($this->params['breadcrumbs'])) : ?>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
      <?php endif ?>
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>
    <?php if( Yii::$app->session->hasFlash('flash') ): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <strong class="me-auto">Системное сообщение</strong>
          <small><?= date('H:i:s')?></small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
        <?php echo Yii::$app->session->getFlash('flash'); ?>
        </div>
      </div>
    </div>
    <?php endif;?>
  </main>
  <footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
      <div class="row text-muted">
        <div class="col-md-6 text-center text-md-start">&copy; <?= Yii::$app->name?> <?= date('Y') ?></div>
        <div class="col-md-6 text-center text-md-end"><?//= Yii::powered() ?></div>
      </div>
    </div>
  </footer>
  <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>