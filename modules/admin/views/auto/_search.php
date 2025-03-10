<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AutoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'public_id') ?>

    <?= $form->field($model, 'preview') ?>

    <?= $form->field($model, 'date_create') ?>

    <?= $form->field($model, 'num_plate') ?>

    <?php // echo $form->field($model, 'owner') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'mark') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'is_visible') ?>

    <?php // echo $form->field($model, 'coast_per_hour') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
