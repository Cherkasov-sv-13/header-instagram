<?php

namespace backend\controllers;

use common\models\data\Account;
use common\models\data\Server;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $accountAllStats['allCount'] = Account::find()
            ->where([
                'is_deleted' => 0,
            ])->count();

        $accountAllStats['GoodCount'] = Account::find()
            ->where([
                'is_deleted' => 0,
                'type' => Account::TYPE_WITHOUT_CAPCHA,
            ])->count();

        $accountAllStats['GoodCapchaCount'] = Account::find()
            ->where([
                'is_deleted' => 0,
                'type' => Account::TYPE_WITH_CAPCHA,
            ])->count();

        $serverAllStats['allCount'] = Server::find()->count();
        $serverAllStats['GoodCount'] = Server::find()
            ->where(
                ['error' => null]
            )->count();
        $serverAllStats['ErrorCount'] = Server::find()
            ->where(
                ['not', ['error' => null]]
            )->count();

        $servers = Server::find()->all();

        return $this->render('index', [
            'accountAllStats' => $accountAllStats,
            'serverAllStats' => $serverAllStats,
            'servers' => $servers,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-local';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
