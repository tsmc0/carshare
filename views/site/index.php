<?php

/** @var yii\web\View $this */

$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Главная']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, аренда авто, каталог автомобилейб каршэринг, каршеринг']);

$userName = Yii::$app->getUser()->identity;
$fullName = "{$userName->second_name} {$userName->first_name} {$userName->father_name}";

$this->title = 'CarShare - Главная';
?>
<div class='base-home'>
    <div class='base-card city-back flex-col car-ad'>
        <p>Есть свободное авто?</p>
        <h1>Зарабатывайте на сдаче авто в каршеринг</h1>
        <a class='btn btn-primary' href="add-car">Добавить</a>
    </div>
    <div class='base-card flex-col'>
        <div class='base-card-head'>Арендуемые авто</div>
        <div class='auto-rent-list no-rent'>
            <?php if (count($rent) == 0): ?>
                <div class='t-text'>Нет арендуемых авто</div>
            <?php else: ?>
                <?php foreach ($rent as $r): ?>
                    <div class='rent'>
                        Дата аренды <?= $r->date_take ?><br>
                        Авто <?= \app\models\Auto::findOne($r->auto)->mark . ' ' . \app\models\Auto::findOne($r->auto)->model ?>
                        <br>
                        Время аренды <?= $r->long_in_hours ?> час/часов
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class='base-card user-prof flex-col'>
        <div class='base-card-head'>Профиль</div>
        <?php if (!Yii::$app->user->identity->is_verified): ?>
            <div class='user-not-ver flex-row'>
                <svg class='icon-yellow' viewBox="0 0 20 20">
                    <use href="/web/icons/icon-sprite.svg#alert"></use>
                </svg>
                <div class='user-not-ver-data flex-col'>
                    <div class='h-text'>Требуется верификация</div>
                    <div class='t-text'>Добавьте в профиль номер телефона, паспортные данные и данные водительского
                        удостоверения, чтобы продолжить использование сервиса
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class='user-data-card flex-col' onclick="redirect('profile')">
            <div class='t-text'>ФИО</div>
            <div class='h-text'><?= $fullName ?></div>
        </div>
        <div class='user-data-card flex-col' onclick="redirect('profile')">
            <div class='t-text'>EMAIL</div>
            <div class='h-text'><?= Yii::$app->user->identity->email ?></div>
        </div>
        <div class='user-data-card flex-col' onclick="redirect('profile')">
            <div class='t-text'>Номер телефона</div>
            <div class='h-text'><?= (is_null($n = Yii::$app->user->identity->phone_number)) ? '<i>Номер не указан</i>' : $n ?></div>
        </div>
        <div class='user-data-card flex-col' onclick="redirect('profile')">
            <div class='t-text'>Верификация по документам</div>
            <div class='h-text'><?= (is_null($n = Yii::$app->user->identity->passport) || is_null($n = Yii::$app->user->identity->drive_license)) ? '<i>Не верифицирован</i>' : '<g>Верифицирован</g>' ?></div>
        </div>
    </div>
    <div class='base-card flex-col'>
        <div class='base-card-head'>Ваши группы</div>
        <div class='auto-rent-list no-rent'>
            <?php if (count($rent) == 0): ?>
                <div class='t-text'>Нет созданных групп</div>
            <?php else: ?>
                <?php foreach ($rent as $r): ?>
                    <div class='rent'>
                        Дата аренды <?= $r->date_take ?><br>
                        Авто <?= \app\models\Auto::findOne($r->auto)->mark . ' ' . \app\models\Auto::findOne($r->auto)->model ?>
                        <br>
                        Время аренды <?= $r->long_in_hours ?> час/часов
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
