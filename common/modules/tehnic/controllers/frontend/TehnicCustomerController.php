<?php

namespace common\modules\tehnic\controllers\frontend;

use common\models\Customer;
use common\models\Launch;
use common\modules\tehnic\models\Tehnic;
use Yii;
use common\modules\tehnic\models\TehnicCustomer;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientController implements the CRUD actions for client model.
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
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all client models.
     * @return mixed
     */

    public function actionAdd($slug)
    {
        $slug = Yii::$app->request->get('slug');
        $launch = Launch::findOne($slug);
        $tehnic = Tehnic::findOne($slug);
        if (empty($launch)) return false;

        $model = new Customer();
        $customer = new TehnicCustomer();

        $customer->order_id = $launch->id;
        $model->owner_id = $launch->author_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Ваш заказ принят, с вами свяжутся в ближайшее время для уточнения заявки.');
            return $this->redirect(['tehnic/view', 'slug' => $launch->slug]);
        } else {
            return $this->render('index', [
                'model' => $model,
                'launch' => $launch,
                'customer' => $customer,
                'tehnic' => $tehnic,
            ]);
        }
    }

    /**
     * Finds the client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    //protected function findModel($id)
    //{
    //    if (($model = client::findOne($id)) !== null) {
    //        return $model;
    //    } else {
    //        throw new NotFoundHttpException('The requested page does not exist.');
    //    }
    //}
}
