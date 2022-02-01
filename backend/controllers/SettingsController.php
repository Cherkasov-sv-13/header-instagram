<?php

namespace backend\controllers;

use common\helpers\TelegramHelper;
use common\models\data\Config;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class SettingsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $configs = Config::find()->all();

        if (Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('Config') as $slug => $value) {
                $model = Config::findOne(['slug' => $slug]);
                $model->value = $value;

                if (!$model->save()) {
                    Yii::$app->session->addFlash(
                        'error',
                        'Настройка "' . $model->name . '" не сохранена. Ошибки: ' .
                        implode(' ', $model->getFirstErrors())
                    );

                    return $this->render('index', compact('configs',));
                }
            }

            Yii::$app->session->addFlash('success', 'Успешно сохранено.');
        }

        $configs = Config::find()->all();

        return $this->render('index', compact('configs'));
    }

    public function actionTestTelegram()
    {
        if (empty(Config::getValueBySlug('telegram-chat')) || empty(Config::getValueBySlug('token-bot'))) {
            Yii::$app->session->addFlash('error',
                'Ошибка отправки. Неправильно указаны настройки телеграмм.');

            return $this->redirect(Yii::$app->request->referrer);
        }

        try {
            TelegramHelper::sendMessage([
                'chat_id' => Config::getValueBySlug('telegram-chat'),
                'text' => 'Тестовое сообщение. Время ' . date('d-m-Y h:i:s'),
            ]);


        } catch (\Exception $exception) {
            Yii::$app->session->addFlash('error', 'Ошибка отправки:' . $exception->getMessage());

            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->session->addFlash('success', 'Сообщение успешно отправлено.');

        return $this->redirect(Yii::$app->request->referrer);
    }
}
