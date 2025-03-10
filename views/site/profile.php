<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Авторизация/Регистраиця']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, авторизация, регистрация, создать аккаунт, аренда авто']);

$this->title = 'CarShare - Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>


</style>
<div class='profile-form flex-col'>
    <h1 class='base-title' id='BT'>Профиль</h1>
    <?php if (!Yii::$app->user->identity->is_verified): ?>
        <div class='user-not-ver flex-row'>
            <svg class='icon-yellow' viewBox="0 0 20 20" width="20px" height="20px">
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
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'class' => 'flex-col',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'second_name')->textInput(['autofocus' => true, 'value' => $user->second_name]) ?>
    <?= $form->field($model, 'first_name')->textInput(['autofocus' => true, 'value' => $user->first_name]) ?>
    <?= $form->field($model, 'father_name')->textInput(['autofocus' => true, 'value' => $user->father_name]) ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'value' => $user->email]) ?>
    <?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7 (999)-999-99-99', 'value' => $user->phone_number,
    ]) ?>
    <?= $form->field($model, 'drive_license')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '999999', 'value' => $user->drive_license,
    ]) ?>
    <?= $form->field($model, 'passport')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '99 99 999999', 'value' => $user->passport,
    ]) ?>


    <?= Html::button('Обновить данные', ['class' => 'btn btn-primary', 'id' => 'login-button', 'role' => 'button']) ?>

    <?php ActiveForm::end(); ?>
</div>
<script>
    document.body.classList.add('wave-background');

    const submitButton = document.getElementById('login-button');
    submitButton.addEventListener('click', baseAction)

    function baseAction() {
        const body = {
            'phone_number': gid('profileform-phone_number').value,
            'drive_license': gid('profileform-drive_license').value,
            'passport': gid('profileform-passport').value,
        };

        const formDescription = {
            'url': PROFILE_UPDATE,
            'params': {
                'method': 'post',
                'body': JSON.stringify(body),
                'headers': {
                    'content-type': 'application/json;charset=utf8;',
                }
            }
        }

        bindFormSend(formDescription, (res) => {
            console.log(res)

            if (res) {
                alert('Данные профиля успешо обновлены');
            } else {
                alert('Не удалось обновить данные профиля');
            }
        })
    }
</script>
