<?php

use yii\helpers\Html;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Рецепты', 'icon' => 'file-code-o', 'url' => ['/recipe/index']],
                    ['label' => 'Ингридиенты', 'icon' => 'file-code-o', 'url' => ['/ingridient/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
