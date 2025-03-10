<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Создать новую группы']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, авторизация, регистрация, создать аккаунт, аренда авто']);

$this->title = 'Добавить авто в группу';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class='basic-form flex-col'>
    <h1 class='base-title' id='BT'>Добавить авто в группу</h1>
    <?php $form = ActiveForm::begin(['id' => 'group']); ?>

    <?= $form->field($model, 'auto')->dropdownList($rentCars,
        ['prompt' => 'Выбрать автомобиль']
    ); ?>

    <?= Html::button('Добавить', ['class' => 'btn btn-primary', 'id' => 'login-button', 'role' => 'button']) ?>

    <?php ActiveForm::end(); ?>
</div>
<script>
    document.body.classList.add('wave-background');

    const teamID = "<?= $teamID ?>";

    const submitButton = document.getElementById('login-button');
    submitButton.addEventListener('click', baseAction)

    function baseAction() {
        const elem = gid('addcargroupform-auto');

        const body = {
            'team': teamID,
            'selectedCar': elem.options[elem.selectedIndex].value
        };

        const formDescription = {
            'url': window.location.href,
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
                alert('Не удалось добавить авто в группу');
            }
        })
    }
</script>
