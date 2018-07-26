<?php

namespace common\modules\construction\controllers\admin;

use dsx90\launcher\models\Launch;
use dsx90\launcher\search\LaunchSearch;
use Yii;
use common\modules\construction\models\Construction;
use common\modules\construction\search\ConstructionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConstructionController implements the CRUD actions for Construction model.
 */
class ConstructionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Construction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Construction();

        $searchModel = new ConstructionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Construction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'launch' => Launch::findOne($id)
        ]);
    }

    /**
     * Creates a new Construction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Construction();
        $launch = new Launch();

        if ($model->load(Yii::$app->request->post()) && $launch->load(Yii::$app->request->post())) {
            $isValid = $model->validate();
            $isValid = $launch->validate() && $isValid;
            if ($isValid){
                $launch->save(false);
                $model->launch_id = $launch->id;
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->launch_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'launch' => $launch
        ]);
    }

    /**
     * Updates an existing Construction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $launch = $this->launchModel($id);

        if (!isset($model, $launch)) {
            throw new NotFoundHttpException("The launch was not found.");
        }

        if ($model->load(Yii::$app->request->post()) && $launch->load(Yii::$app->request->post())) {
            $isValid = $model->validate();
            $isValid = $launch->validate() && $isValid;
            if ($isValid){
                $model->save(false);
                $launch->save(false);
                return $this->redirect(['view', 'id' => $model->launch_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'launch' => $launch
        ]);
    }

    /**
     * Deletes an existing Construction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->launchModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function launchModel($id)
    {
        if (($launch = Launch::findOne($id)) !== null) {
            return $launch;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Construction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Construction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Construction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
