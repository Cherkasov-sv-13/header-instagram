<?php

namespace frontend\controllers;

use common\helpers\ApiEnum;
use common\helpers\TelegramHelper;
use common\models\data\Config;
use common\models\data\Server;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class ServerController extends Controller
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
                    'error' => ['get'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionError()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $serverName = Yii::$app->request->get('server');
        $errorStr = Yii::$app->request->get('message');

        if (empty($serverName)) {
            return [
                'status' => ApiEnum::ERROR,
                'message' => 'Неверно указан server.',
            ];
        }

        $server = Server::findOne(['name' => $serverName]);

        if (empty($server)) {
            TelegramHelper::sendMessage([
                'chat_id' => Config::getValueBySlug('telegram-chat'),
                'text' => '‼️‼️‼️ Ошибка на сервере "' . $serverName . '". Внимание: этот сервер не найден в базе. Ошибка: ' . $errorStr,
            ]);
            return [
                'status' => ApiEnum::ERROR,
                'message' => 'Сервер не найден.',
            ];
        }

        $server->error = $errorStr;

        if (!$server->save()) {
            return [
                'status' => ApiEnum::ERROR,
                'message' => 'Не удалось сохранить сервер.',
            ];
        }

        TelegramHelper::sendMessage([
            'chat_id' => Config::getValueBySlug('telegram-chat'),
            'text' => '‼️‼️‼️ Ошибка на сервере "' . $serverName . '". Ошибка: ' . $errorStr,
        ]);

        return [
            'status' => ApiEnum::SUCCESS,
        ];
    }
}
