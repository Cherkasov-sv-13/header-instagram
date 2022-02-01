<?php

use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\data\Account
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Аккаунты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="box box-solid">
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'data',
                [
                    'attribute' => 'type',
                    'value' => $model->getTypeStr(),
                ],
                [
                    'attribute' => 'created_at',
                    'value' => Yii::$app->formatter->asDatetime($model->created_at),
                ],
                'is_deleted:boolean',
            ],
        ]) ?>
    </div>
</div>
