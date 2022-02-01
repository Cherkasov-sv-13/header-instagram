<?php

use common\models\data\Server;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сервера';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-solid box-primary">
    <div class="box-body">

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
            'rowOptions' => function ($model, $key, $index, $grid) {
                return !empty($model->error) ? ['style' => ' background: #ffacac;'] : ['style' => ''];
            },
            'columns' => [
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'contentOptions' => ['style' => 'width: 80px;'],
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Количество аккаунтов',
                    'filter' => false,
                    'contentOptions' => ['style' => 'width:180px;'],
                    'value' => function (Server $model) {
                        return $model->getCountAccount();
                    },
                ],
                [
                    'attribute' => 'name',
                    'contentOptions' => [],
                ],
                [
                    'attribute' => 'error',
                ],
            ],
        ]); ?>
    </div>
</div>
