<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Авторизация/Регистраиця']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, авторизация, регистрация, создать аккаунт, аренда авто']);

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .field-loginform-password {
        display: none;
        animation: fade-in-left .35s cubic-bezier(.39, .575, .565, 1.000) both;
    }

</style>
<div class='basic-form flex-col'>
    <h1 class='base-title' id='BT'>Войти в аккаунт</h1>
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

    <?= $form->field($model, 'credential')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput()->hiddenInput() ?>

    <?= Html::button('Продолжить', ['class' => 'btn btn-primary', 'id' => 'login-button', 'role' => 'button']) ?>

    <?php ActiveForm::end(); ?>
</div>
<script>
    document.body.classList.add('wave-background');

    const submitButton = document.getElementById('login-button');
    let isFoundIdentity = false;
    submitButton.addEventListener('click', baseAction)

    function baseAction() {
        const body = {
            'credential': gid('loginform-credential').value,
        };

        const formDescription = {
            'url': LOGIN_ACTION,
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

            if (res.state === 0x0) {
                redirect('signup')
            } else if (res.state === 0x1) {
                isFoundIdentity = true;

                getParentNode(gid('loginform-password')).style.display = 'flex';
                gid('loginform-password').setAttribute('type', 'password');
                gid('BT').innerHTML = `С возвращением, <b>${res.content}</b>👋`;
                gid('login-button').textContent = 'Войти в аккаунт';

                submitButton.removeEventListener('click', baseAction);
                submitButton.addEventListener('click', passwordAction)
            }
        })
    }

    function passwordAction() {
        const body = {
            'credential': gid('loginform-credential').value,
            'password': gid('loginform-password').value
        };

        const formDescription = {
            'url': LOGIN_ACTION_PASSWORD,
            'params': {
                'method': 'post',
                'body': JSON.stringify(body),
                'headers': {
                    'content-type': 'application/json;charset=utf8;',
                }
            }
        }

        bindFormSend(formDescription, (res) => {
            console.log(res, 'pass')

            if (res.state === 0x3) {
                redirect('home')
            } else if (res.state === 0x2) {

            }
        })
    }
</script>
