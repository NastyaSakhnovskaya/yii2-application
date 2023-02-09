<?php

namespace frontend\controllers;

use frontend\models\Routes;
use frontend\models\RoutesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminroutesController implements the CRUD actions for Routes model.
 */
class AdminroutesController extends Controller
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
     * Lists all Routes models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RoutesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Routes model.
     * @param int $route_id Route ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($route_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($route_id),
        ]);
    }

    /**
     * Creates a new Routes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Routes();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'route_id' => $model->route_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Routes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $route_id Route ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($route_id)
    {
        $model = $this->findModel($route_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'route_id' => $model->route_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Routes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $route_id Route ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($route_id)
    {
        $this->findModel($route_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Routes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $route_id Route ID
     * @return Routes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($route_id)
    {
        if (($model = Routes::findOne(['route_id' => $route_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
