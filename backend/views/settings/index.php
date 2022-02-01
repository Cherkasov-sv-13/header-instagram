<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $configs \common\models\data\Config[]
 */

$this->title = 'Настройки';
?>
<div class="site-index">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Настройки приложения</h3>
                </div>
                <div class="box-body">
                    <?php foreach ($configs as $config): ?>
                        <div class="form-group">
                            <?= Html::label($config->name) ?>
                            <?= Html::textInput(
                                'Config[' . $config->slug . ']',
                                $config->value,
                                ['class' => 'form-control', 'placeholder' => 'Введите ' . $config->name]
                            ) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="box-footer text-right">
                    <?= Html::submitButton('Сохранить',
                        ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <div class="col-xs-12 col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Тестовое сообщение в телеграмм</h3>
                </div>
                <div class="box-body">
                    <p><a class="btn btn-default" href="/admin/settings/test-telegram">Отправить</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

