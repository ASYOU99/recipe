<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ingridient */

$this->title = 'Create Ingridient';
$this->params['breadcrumbs'][] = ['label' => 'Ingridients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingridient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
