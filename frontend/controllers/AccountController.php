<?php

namespace frontend\controllers;

use common\helpers\ApiEnum;
use common\helpers\TelegramHelper;
use common\models\data\Account;
use common\models\data\Config;
use common\models\data\Server;
use Yii;
use yii\base\DynamicModel;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class AccountController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'good' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionGood()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $serverName = Yii::$app->request->post('server');
        $accountData = Yii::$app->request->post('account');
        $type = Yii::$app->request->post('type');

        if (empty($serverName)) {
            return [
                'status' => ApiEnum::ERROR,
                'massage' => 'Не передан параметр server.',
            ];
        }

        if (empty($accountData)) {
            return [
                'status' => ApiEnum::ERROR,
                'massage' => 'Не передан параметр account.',
            ];
        }

        if (empty($type)) {
            return [
                'status' => ApiEnum::ERROR,
                'massage' => 'Не передан параметр type.',
            ];
        }

        $server = Server::createOrFindServer($serverName);

        if ($server === null) {
            TelegramHelper::sendMessage([
                'chat_id' => Config::getValueBySlug('telegram-chat'),
                'text' => 'Ошибка сохранения аккаунта: ' . $accountData . '. Сервер: ' . $serverName . '. Не удалось создать сервер.',
            ]);

            return [
                'status' => ApiEnum::ERROR,
                'massage' => 'Ошибка создания сервера',
            ];
        }

        $account = new Account([
            'data' => $accountData,
            'type' => $type,
            'server_id' => $server->id,
        ]);

        if (!$account->save()) {
            TelegramHelper::sendMessage([
                'chat_id' => Config::getValueBySlug('telegram-chat'),
                'text' => 'Ошибка сохранения аккаунта: ' . $accountData . '. Сервер: ' . $serverName . '. Не удалось сохранить аккаунт.',
            ]);

            return [
                'status' => ApiEnum::ERROR,
                'massage' => 'Ошибка сохранения аккаунта',
            ];
        }


        return [
            'status' => ApiEnum::SUCCESS,
        ];
    }
}
