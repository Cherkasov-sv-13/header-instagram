<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\data\Server
 * @var $addressDataProvider
 * @var $addressSearchModel
 * @var $cartSearchModel
 * @var $cartDataProvider
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сервера', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<p>
    <?= Html::a('Выгрузить аккаунты', ['download-accounts', 'server_id' => $model->id],
        ['class' => 'btn btn-primary']) ?>
</p>

<div class="box box-solid">
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                [
                    'attribute' => 'countAccount',
                    'label' => 'Количество аккаунтов',
                    'value' => $model->getCountAccount(),
                ],
                'error',
            ],
        ]) ?>
    </div>
</div>
