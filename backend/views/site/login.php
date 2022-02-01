<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \admin\models\form\LoginForm */

$this->title = 'Войти';
?>

<div class="login-box">
    <div class="login-logo">
        <b><?= Yii::$app->params['appName'] ?></b>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Введите логин и пароль для входа</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username')
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password')
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model,
                    'rememberMe')->checkbox(['placeholder' => $model->getAttributeLabel('rememberMe')]) ?>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('Войти', [
                    'class' => 'btn btn-block btn-flat',
                    'name' => 'login-button',
                    'style' => 'background-color:#19a347; color: white',
                ]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
