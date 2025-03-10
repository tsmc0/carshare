<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Авторизация/Регистраиця']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, авторизация, регистрация, создать аккаунт, аренда авто']);

$this->title = 'Создать аккаунт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='basic-form flex-col'>
    <h1 class='base-title'>Создать аккаунт</h1>
    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'class' => 'flex-col',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>


    <?= $form->field($model, 'second_name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'father_name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>


    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= Html::button('Создать аккаунт', ['class' => 'btn btn-primary', 'id' => 'login-button', 'role' => 'button']) ?>

    <?php ActiveForm::end(); ?>
</div>
<script>
    document.body.classList.add('wave-background');

    document.getElementById('login-button').addEventListener('click', () => {
        const body = new FormData(gid('signup-form'))

        const formDescription = {
            'url': 'site/signup',
            'params': {
                'method': 'post',
                'body': body
            }
        }

        bindFormSend(formDescription, (res) => {
            console.log(res)

            if (res) {
                redirect('login')
            } else {
                alert(res)
            }
        })
    })
</script>
