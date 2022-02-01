<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

/**
 * @var $content string
 */
?>

<div class="content-wrapper">

    <section class="content-header">
        <div class="row">
            <div class="col-md-12">
                <h1> <?= $this->title ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Breadcrumbs::widget(
                    [
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'homeLink' => false,
                    ]
                ) ?>
            </div>
        </div>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>