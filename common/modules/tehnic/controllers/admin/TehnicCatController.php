<?php

namespace common\modules\tehnic\controllers\admin;

use common\models\Launch;
use Yii;
use common\modules\tehnic\models\TehnicCat;
use common\modules\tehnic\search\TehnicCatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TehnicCatController implements the CRUD actions for TehnicCat model.
 */
class TehnicCatController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TehnicCat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TehnicCatSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TehnicCat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TehnicCat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TehnicCat();
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
        return $this->render('create', [
            'model' => $model,
            'launch' => $launch
        ]);
    }

    /**
     * Updates an existing TehnicCat model.
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
     * Deletes an existing TehnicCat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
     * Finds the TehnicCat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TehnicCat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TehnicCat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
