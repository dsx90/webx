<?php

namespace common\modules\tehnic\controllers\admin;

use common\modules\tehnic\models\TehnicOptionValue;
use Yii;
use common\modules\tehnic\models\Tehnic;
use common\modules\tehnic\search\TehnicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Launch;

/**
 * TehnicController implements the CRUD actions for Tehnic model.
 */
class TehnicController extends Controller
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
     * Lists all Tehnic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TehnicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tehnic model.
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
     * Creates a new Tehnic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tehnic();
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
            'launch' => $launch,
            'options' => [new TehnicOptionValue]
        ]);
    }

    /**
     * Updates an existing Tehnic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $launch = $this->launchModel($id);
        $options = $model->options;

        if (!isset($model, $launch)) {
            throw new NotFoundHttpException("The launch was not found.");
        }

        if ($model->load(Yii::$app->request->post()) && $launch->load(Yii::$app->request->post())) {
            $isValid =  $launch->validate() && $model->validate();
            if ($isValid){
                $model->save(false);
                $model->saveRelation();
                $launch->save(false);
                return $this->redirect(['view', 'id' => $model->launch_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'options' => !$options ? [new TehnicOptionValue] : $options,
            'launch' => $launch
        ]);
    }

    /**
     * Deletes an existing Tehnic model.
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
     * Finds the Tehnic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tehnic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tehnic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
