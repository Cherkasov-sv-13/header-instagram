<?php

use common\models\data\Account;
use common\models\data\Server;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $config \common\models\data\Config
 */

$this->title = 'Дашборд';
?>
<div class="site-index">
    <h4><i class="fa fa-users"></i> Аккаунты</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-solid p-5">
                <span class="info-box-text">Всего аккаунтов</span>
                <span class="info-box-number"><?= $accountAllStats['allCount'] ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid p-5">
                <span class="info-box-text">Аккаунты (<?= Account::typeList()[Account::TYPE_WITHOUT_CAPCHA] ?>)</span>
                <span class="info-box-number"><?= $accountAllStats['GoodCount'] ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid p-5">
                <span class="info-box-text">Аккаунты (<?= Account::typeList()[Account::TYPE_WITH_CAPCHA] ?>)</span>
                <span class="info-box-number"><?= $accountAllStats['GoodCapchaCount'] ?></span>
            </div>
        </div>
    </div>

    <h4><i class="fa fa-server"></i> Сервера</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-solid p-5">
                <span class="info-box-text">Всего серверов</span>
                <span class="info-box-number"><?= $serverAllStats['allCount'] ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid p-5">
                <span class="info-box-text">Сервера без ошибок</span>
                <span class="info-box-number"><?= $serverAllStats['GoodCount'] ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid p-5"
                 style="<?= $serverAllStats['ErrorCount'] > 0 ? 'background: #ff9191;' : '' ?>">
                <span class="info-box-text">Сервера с ошибками</span>
                <span class="info-box-number"><?= $serverAllStats['ErrorCount'] ?></span>
            </div>
        </div>
    </div>

    <h4><i class="fa fa-area-chart"></i> Статистика</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-solid p-5">
                <div class="row m-sm-2">
                    <div class="col-md-12">
                        <label for="server-list">Период</label>
                        <?= Html::dropDownList('period', null, [
                                1 => 'За все время',
                                2 => 'За послейдний час',
                                3 => 'За сегодня',
                                4 => 'За вчера',
                            ]
                            , [
                                'id' => 'server-list',
                                'class' => 'form-control',
                            ]) ?>
                    </div>
                </div>
                <br>
                <div class="row p-2">
                    <div class="col-8 text-left">
                        <strong>Аккаунты (Всего)</strong>
                    </div>
                    <div class="col-4 text-right" id="js-all-stat-all">
                        <?= Account::getCount() ?>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-8 text-left">
                        <strong>Аккаунты (<?= Account::typeList()[Account::TYPE_WITHOUT_CAPCHA] ?>)</strong>
                    </div>
                    <div class="col-4 text-right" id="js-all-stat-without">
                        <?= Account::getCountWithOutCapcha() ?>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-8 text-left">
                        <strong>Аккаунты (<?= Account::typeList()[Account::TYPE_WITH_CAPCHA] ?>)</strong>
                    </div>
                    <div class="col-4 text-right" id="js-all-stat-with">
                        <?= Account::getCountWithCapcha() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        /* @var Server $server */
        foreach ($servers as $server) {
            ?>
            <div class="col-md-4">
                <div class="box box-solid p-5" style="<?= !empty($server->error) > 0 ? 'background: #ff9191;' : '' ?>">
                    <div class="row p-2">
                        <div class="col-12 text-left">
                            <h4><?= $server->name ?></h4>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-8 text-left">
                            <strong>Аккаунты (Всего)</strong>
                        </div>
                        <div class="col-4 text-right" id="js-stat-all" data-server-id="<?= $server->id ?>">
                            <?= $server->getCountAccount() ?>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-8 text-left">
                            <strong>Аккаунты (<?= Account::typeList()[Account::TYPE_WITHOUT_CAPCHA] ?>)</strong>
                        </div>
                        <div class="col-4 text-right" id="js-stat-without" data-server-id="<?= $server->id ?>">
                            <?= $server->getCountWithOutCapchaAccount() ?>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-8 text-left">
                            <strong>Аккаунты (<?= Account::typeList()[Account::TYPE_WITH_CAPCHA] ?>)</strong>
                        </div>
                        <div class="col-4 text-right" id="js-stat-with" data-server-id="<?= $server->id ?>">
                            <?= $server->getCountWithCapchaAccount() ?>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-12 text-left">
                            <strong>Ошибки: </strong> <br>
                            <?= $server->error ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
