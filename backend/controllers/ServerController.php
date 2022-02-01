<?php

namespace backend\controllers;

use common\helpers\ApiEnum;
use common\models\data\Account;
use common\models\data\Server;
use common\models\search\ServerSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ServerController implements the CRUD actions for Server model.
 */
class ServerController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Server models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Server model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Server model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Server();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Server model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDownloadAccounts($server_id)
    {
        $model = $this->findModel($server_id);

        if (Yii::$app->request->isPost) {
            $type = Yii::$app->request->post('type');

            if (empty($type)) {
                Yii::$app->session->addFlash('error', 'Неверное значение типа');

                return $this->render('download-accounts', [
                    'model' => $model,
                ]);
            }

            $content = Account::getContentForFile($type, $server_id);

            return Yii::$app->response->sendContentAsFile(
                $content,
                'Accounts-type-' . Account::typeList()[$type] . '-server-' . $model->name . '-' . date('d-m-Y-h-i-s') . '.txt'
            );
        }

        return $this->render('download-accounts', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Server model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Server model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Server the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Server::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStats()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $period = Yii::$app->request->get('period');

        if (empty($period)) {
            return [
                'status' => ApiEnum::ERROR,
                'message' => 'Не передан параметр period',
            ];
        }

        $startPeriod = null;
        $endPeriod = null;

        switch ($period) {
            case 2:
                $startPeriod = time() - 3600;
                $endPeriod = time() + 3600;
                break;
            case 3:
                $startPeriod = strtotime('today 00:00:00');
                $endPeriod = strtotime('today 23:59:59');
                break;
            case 4:
                $startPeriod = strtotime('yesterday 00:00:00');
                $endPeriod = strtotime('yesterday 23:59:59');
                break;
        }

        $statAllAccount['all'] = Account::find()
            ->where([
                'is_deleted' => 0,
            ])
            ->andFilterWhere(['>=', 'created_at', $startPeriod])
            ->andFilterWhere(['<=', 'created_at', $endPeriod])
            ->count();

        $statAllAccount['withOutCapcha'] = Account::find()
            ->where([
                'is_deleted' => 0,
                'type' => Account::TYPE_WITHOUT_CAPCHA,
            ])
            ->andFilterWhere(['>=', 'created_at', $startPeriod])
            ->andFilterWhere(['<=', 'created_at', $endPeriod])
            ->count();

        $statAllAccount['withCapcha'] = Account::find()
            ->where([
                'is_deleted' => 0,
                'type' => Account::TYPE_WITH_CAPCHA,
            ])
            ->andFilterWhere(['>=', 'created_at', $startPeriod])
            ->andFilterWhere(['<=', 'created_at', $endPeriod])
            ->count();

        return [
            'status' => ApiEnum::SUCCESS,
            'allStat' => $statAllAccount,
            'serversStat' => Server::getAllStat($startPeriod, $endPeriod),
        ];
    }
}
