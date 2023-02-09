<?php

namespace frontend\controllers;

use frontend\models\Bus;
use frontend\models\BusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminbusController implements the CRUD actions for Bus model.
 */
class AdminbusController extends Controller
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
     * Lists all Bus models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BusSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bus model.
     * @param int $bus_id Bus ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bus_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($bus_id),
        ]);
    }

    /**
     * Creates a new Bus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Bus();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'bus_id' => $model->bus_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $bus_id Bus ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bus_id)
    {
        $model = $this->findModel($bus_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bus_id' => $model->bus_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $bus_id Bus ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bus_id)
    {
        $this->findModel($bus_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $bus_id Bus ID
     * @return Bus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bus_id)
    {
        if (($model = Bus::findOne(['bus_id' => $bus_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
