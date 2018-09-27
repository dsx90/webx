<?php

namespace common\modules\tehnic\controllers;

use common\components\dispatcher\Controller;
use common\modules\tehnic\models\Tehnic;
use common\modules\tehnic\search\TehnicCustomerSearch;
use common\modules\tehnic\search\TehnicSearch;
use Yii;

/**
 * Default controller for the `test` module
 */
class LayoutController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ViewNotFoundException
     * @throws \yii\base\InvalidCallException
     */
    /**
     * Lists all Tehnic models.
     * @return mixed
     */
    public function index()
    {
        $searchModelTehnic = new TehnicSearch();
        $dataProviderTehnic = $searchModelTehnic->search(Yii::$app->request->queryParams);

        //$countTehmic = Tehnic::find()->where()

        $searchModelCustomer = new TehnicCustomerSearch();
        $dataProviderCustomer = $searchModelCustomer->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModelTehnic' => $searchModelTehnic,
            'dataProviderTehnic' => $dataProviderTehnic,

            'searchModelCustomer' => $searchModelCustomer,
            'dataProviderCustomer' => $dataProviderCustomer,
        ]);
    }
}
