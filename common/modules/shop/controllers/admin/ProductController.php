<?php

namespace common\modules\shop\controllers\admin;

use common\models\Launch;
use common\modules\shop\models\Product;
use common\modules\shop\search\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `shop` module
 */
class ProductController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $launch = new Launch();

        if ($model->load(\Yii::$app->request->post()) && $launch->load(\Yii::$app->request->post())) {
            $isValid = $model->validate();
            $isValid = $launch->validate() && $isValid;
            if ($isValid){
                $launch->save(false);
                $model->link('launch', $launch);
                $model->save(false);
                return $this->redirect(['update', 'id' => $model->launch_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'launch' => $launch
        ]);
    }

    /**
     * Updates an existing Construction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $launch = $this->launchModel($id);

        if (!isset($model, $launch)) {
            throw new NotFoundHttpException("The launch was not found.");
        }

        if ($model->load(\Yii::$app->request->post()) && $launch->load(\Yii::$app->request->post())) {
            $isValid = $model->validate();
            $isValid = $launch->validate() && $isValid;
            if ($isValid && $model->save(false) && $launch->save(false)){
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
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->launchModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return Launch|null
     * @throws NotFoundHttpException
     */
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
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['launch_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
