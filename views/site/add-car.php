<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Добавление нового авто']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, авторизация, регистрация, создать аккаунт, аренда авто, новое авто, сдать авто в аренду']);

$this->title = 'CarShare - Добавить авто';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .field-loginform-password {
        display: none;
        animation: fade-in-left .35s cubic-bezier(.39, .575, .565, 1.000) both;
    }

</style>
<div class='basic-form flex-col'>
    <h1 class='base-title' id='BT'>Добавить автомобиль для сдачи в аренду</h1>
    <?php $form = ActiveForm::begin([
        'id' => 'add-car-form',
        'class' => 'flex-col dark-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>



    <?= $form->field($model, 'brand')->dropdownList($brands,
        ['prompt' => 'Выберите марку']
    ); ?>

    <div class = 'models-list' id = 'ML'></div>

    <div class = 'car-param'>
        <div class = 't-text'>Автомобиль</div>
        <div class = 'h-text' id = 'MB'></div>
    </div>

    <?= $form->field($model, 'coast_per_hour')->textInput(['autofocus' => true]) ?>

    <?= Html::button('Разместить', ['class' => 'btn btn-primary', 'id' => 'login-button', 'role' => 'button']) ?>

    <?php ActiveForm::end(); ?>
</div>
<script>
    document.body.classList.add('wave-background');

    const autoDesc = {
        "brand": null,
        "model": null,
        "prev": null,
    };

    function selectModel(model) {
        autoDesc.model = model;

        gid('MB').textContent = `${autoDesc.brand} ${autoDesc.model}`
    }

    document.getElementById('addcarform-brand').addEventListener('change', () => {
        const elem = gid('addcarform-brand');

        console.log(elem.options[elem.selectedIndex].text)

        autoDesc.brand = elem.options[elem.selectedIndex].text;

        const body = {
            'brand': elem.options[elem.selectedIndex].text,
        };

        const formDescription = {
            'url': GET_MODELS,
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

            gid('ML').replaceChildren();

            res.forEach((item) => {
                const prev = document.createElement('img')
                prev.src = `https://www.auto-data.net${item.img}`;

                const card = document.createElement('div')
                card.textContent = item.label;
                card.appendChild(prev);

                card.addEventListener('click', () => {
                    document.querySelectorAll('.sl').forEach((int) => {
                        int.classList.remove('sl')
                    })

                    card.classList.add('sl');
                    autoDesc.prev = `https://www.auto-data.net${item.img}`;
                    selectModel(item.label);
                })

                gid('ML').appendChild(card)
            })

        })
    })

    const submitButton = document.getElementById('login-button');
    submitButton.addEventListener('click', baseAction)

    function baseAction() {
        const body = {
            'brand': autoDesc.brand,
            'model': autoDesc.model,
            'cph': gid('addcarform-coast_per_hour').value,
            'preview': autoDesc.prev
        };

        const formDescription = {
            'url': ADD_AUTO,
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

            if (res === true) {
                redirect('home');
            } else {

            }
        })
    }
</script>
