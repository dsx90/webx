<?php

namespace common\modules\tehnic\controllers\admin;

use common\models\Customer;
use Yii;
use common\modules\tehnic\models\TehnicCustomer;
use common\modules\tehnic\search\TehnicCustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TehnicCustomerController implements the CRUD actions for TehnicCustomer model.
 */
class TehnicCustomerController extends Controller
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
     * Lists all TehnicCustomer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TehnicCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TehnicCustomer model.
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
     * Creates a new TehnicCustomer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TehnicCustomer();
        $customer = new Customer();

        if ($model->load(Yii::$app->request->post()) && $customer->load(Yii::$app->request->post())) {
            $isValid = $model->validate();
            $isValid = $customer->validate() && $isValid;
            if ($isValid){
                $customer->save(false);
                $model->customer_id = $customer->id;
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->customer_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'customer' => $customer,
        ]);
    }

    /**
     * Updates an existing TehnicCustomer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TehnicCustomer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TehnicCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TehnicCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TehnicCustomer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
