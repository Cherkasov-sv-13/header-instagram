<?php

use common\models\data\Account;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\data\Server */
$this->title = 'Выгрузить аккаунтыю ';
$this->params['breadcrumbs'][] = ['label' => 'Сервера', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="box box-solid">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <?= Html::dropDownList('type', null, Account::typeList(), ['class' => 'form-control']) ?>
                    </div>
                </div>

            </div>
            <div class="box-footer">
                <?= Html::submitButton('Выгрузить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

