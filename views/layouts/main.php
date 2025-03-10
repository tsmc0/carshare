<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$sideMenu = [
    ['label' => 'Главная', 'url' => 'home', 'icon' => 'home'],
    ['label' => 'Автомобили', 'url' => 'cars', 'icon' => 'car'],
//    ['label' => 'Избранные', 'url' => 'favorite', 'icon' => 'favorite'],
    ['label' => 'Группы', 'url' => 'group', 'icon' => 'group'],
    ['label' => 'Мои авто', 'url' => 'garage', 'icon' => 'garage'],
];

$uri = explode('/', $_SERVER["REQUEST_URI"]);

foreach ($sideMenu as $index => $item) {
    if (end($uri) == $item['url']) {
        $sideMenu[$index]['selected'] = 'active';
    }
    $sideMenu[$index]['selected'] = '';
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class='right-panel flex-col'>
    <div class='right-panel-controls flex-col'>
        <?php foreach ($sideMenu as $item): ?>
            <div class='right-panel-item <?= $item["selected"] ?>'>
                <a href='<?= $item["url"] ?>'>
                    <svg class='right-panel-item-icon transition ' viewBox="0 0 20 20">
                        <use href="/web/icons/icon-sprite.svg#<?= $item['icon'] ?>"></use>
                    </svg>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class='rp-bottom flex-col'>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php if (!Yii::$app->user->identity->is_verified): ?>
                <div class='right-panel-item'>
                    <svg class='right-panel-item-icon transition icon-yellow' viewBox="0 0 20 20">
                        <use href="/web/icons/icon-sprite.svg#alert"></use>
                    </svg>
                </div>
            <?php endif; ?>
            <a href='logout'>
                <div class='right-panel-item'>
                    <svg class='right-panel-item-icon transition icon-red' viewBox="0 0 20 20">
                        <use href="/web/icons/icon-sprite.svg#logout"></use>
                    </svg>
                </div>
            </a>
        <?php else: ?>

        <?php endif; ?>
    </div>
</div>

<div class='scene-content'>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
