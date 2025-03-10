<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Создать новую группы']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, авторизация, регистрация, создать аккаунт, аренда авто']);

$this->title = 'Создать новую группу';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class='basic-form flex-col'>
    <h1 class='base-title' id='BT'>Создать группу</h1>
    <?php $form = ActiveForm::begin(['id' => 'group']); ?>

    <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

    <?= Html::button('Продолжить', ['class' => 'btn btn-primary', 'id' => 'login-button', 'role' => 'button']) ?>

    <?php ActiveForm::end(); ?>
</div>
<script>
    document.body.classList.add('wave-background');

    const submitButton = document.getElementById('login-button');
    submitButton.addEventListener('click', baseAction)

    function baseAction() {
        const body = {
            'title': gid('teamform-title').value
        };

        const formDescription = {
            'url': CREATE_GROUP,
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
                redirect('group')
            } else {
                alert('Не удалось создать группу');
            }
        })
    }
</script>
