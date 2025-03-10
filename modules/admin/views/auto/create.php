<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Auto $model */

$this->title = 'Create Auto';
$this->params['breadcrumbs'][] = ['label' => 'Autos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
