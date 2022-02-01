<?php

use common\models\data\Account;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Аккаунты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-solid box-primary">
    <div class="box-body">
        <p>
            <?= Html::a('Выгрузить аккаунты', ['download'], ['class' => 'btn btn-primary']) ?>
        </p>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => [
                'firstPageLabel' => 'В начало',
                'lastPageLabel' => 'В конец',
            ],
            'options' => [
                'class' => 'table-responsive',
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}',
                    'contentOptions' => ['style' => 'width: 80px;'],
                ],
                [
                    'attribute' => 'data',
                    'contentOptions' => [],
                ],
                [
                    'attribute' => 'type',
                    'filter' => false,
                    'contentOptions' => ['style' => 'width:180px;'],
                    'value' => function (Account $model) {
                        return $model->getTypeStr();
                    },
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Время регистрации',
                    'filter' => false,
                    'contentOptions' => ['style' => 'width:180px;'],
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDatetime($model->created_at);
                    },
                ],
                [
                    'attribute' => 'is_deleted',
                    'format' => 'boolean',
                    'contentOptions' => ['style' => 'width: 100px;'],
                    'filterInputOptions' => [
                        'prompt' => '(все)',
                        'class' => 'form-control',
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
