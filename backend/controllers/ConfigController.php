<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 0:32
 */

namespace backend\controllers;

use yii\base\Model;
use yii\web\Controller;
use Yii;

class ConfigController extends Controller
{
    /**
     * Performs batch updated of application configuration records.
     */
    public function actionIndex()
    {
        /* @var $configManager \yii2tech\config\Manager */
        $configManager = Yii::$app->get('configManager');

        $models = $configManager->getItems();

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $configManager->saveValues();
            Yii::$app->session->setFlash('success', 'Configuration updated.');
            return $this->refresh();
        }

        return $this->render('index', [
            'models' => $models,
        ]);
    }

    /**
     * Restores default values for the application configuration.
     */
    public function actionDefault()
    {
        /* @var $configManager \yii2tech\config\Manager */
        $configManager = Yii::$app->get('configManager');
        $configManager->clearValues();
        Yii::$app->session->setFlash('success', 'Default values restored.');
        return $this->redirect(['index']);
    }
}