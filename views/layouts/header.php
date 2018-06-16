<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <nav class="navbar navbar-static-top" role="navigation">
        <?= Html::a(
            'Выйти',
            ['/user/logout'],
            ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
        ) ?>
    </nav>
</header>
