<?php

use dmstr\widgets\Menu;

?>

<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        if (!Yii::$app->user->isGuest): ?>
            <?php $user = Yii::$app->user; ?>
            <?= Menu::widget([
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Дашборд', 'url' => '/admin/site', 'icon' => ' fa-area-chart '],
                    ['label' => 'Аккаунты', 'url' => '/admin/account', 'icon' => ' fa fa-users '],
                    ['label' => 'Сервера', 'url' => '/admin/server', 'icon' => ' fa fa-server '],
                    ['label' => 'Настройки', 'url' => '/admin/settings', 'icon' => 'cogs',],
                    ['label' => 'Выйти', 'url' => '/admin/site/logout', 'icon' => ' fa fa-sign-out ',],
                ],
            ]) ?>
        <?php endif; ?>
    </section>

</aside>
