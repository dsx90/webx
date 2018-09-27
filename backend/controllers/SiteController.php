<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\components\keyStorage\FormModel;
use common\models\LoginForm;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use vova07\imperavi\actions\GetFilesAction;
use vova07\imperavi\actions\GetImagesAction;
use vova07\imperavi\actions\UploadFileAction;

/**
 * Class SiteController.
 */
class SiteController extends Controller
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@storage/tmp',
            ],
            'images-get' => [
                'class' => GetImagesAction::className(),
                'url' => Yii::getAlias('@storageUrl/images'),
                'path' => '@storage/images',
            ],
            'files-get' => [
                'class' => GetFilesAction::className(),
                'url' => Yii::getAlias('@storageUrl/files'),
                'path' => '@storage/files',
            ],
            'image-upload' => [
                'class' => UploadFileAction::className(),
                'url' => Yii::getAlias('@storageUrl/images/' . date('m.y')),
                'path' => '@storage/images/' . date('m.y'),
            ],
            'file-upload' => [
                'class' => UploadFileAction::className(),
                'url' => Yii::getAlias('@storageUrl/files/' . date('m.y')),
                'path' => '@storage/files/' . date('m.y'),
                'uploadOnlyImage' => false,
            ],

            'upload'=>[
                'class'=>'fbalabanov\filekit\actions\UploadAction',
                'deleteRoute' => 'upload-delete',
                'fileparam' => 'file',
            ],
            'upload-delete' => [
                'class' => 'fbalabanov\filekit\actions\DeleteAction'
            ],
            'upload-imperavi' => [
                'class' => 'fbalabanov\filekit\actions\UploadAction',
                'fileparam' => 'file',
                'responseUrlParam'=> 'filelink',
                'multiple' => false,
                'disableCsrf' => true
            ],
            'view'=>[
                'class'=>'fbalabanov\filekit\actions\ViewAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'layout';

        $modules = \Yii::$app->dispatcher->modules(1);

        return $this->render('index', compact('modules'));
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'main-login' : 'main';

        return parent::beforeAction($action);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSettings()
    {
        $model = new FormModel([
            'keys' => [
                'frontend.registration' => [
                    'label' => Yii::t('backend', 'Registration'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        false => Yii::t('backend', 'Disabled'),
                        true => Yii::t('backend', 'Enabled'),
                    ],
                ],
                'frontend.email-confirm' => [
                    'label' => Yii::t('backend', 'Email confirm'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        false => Yii::t('backend', 'Disabled'),
                        true => Yii::t('backend', 'Enabled'),
                    ],
                ],
                'frontend.maintenance' => [
                    'label' => Yii::t('backend', 'Frontend maintenance mode'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        false => Yii::t('backend', 'Disabled'),
                        true => Yii::t('backend', 'Enabled'),
                    ],
                ],
                'backend.theme-skin' => [
                    'label' => Yii::t('backend', 'Backend theme'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'skin-blue' => 'skin-blue',
                        'skin-black' => 'skin-black',
                        'skin-red' => 'skin-red',
                        'skin-yellow' => 'skin-yellow',
                        'skin-purple' => 'skin-purple',
                        'skin-green' => 'skin-green',
                        'skin-blue-light' => 'skin-blue-light',
                        'skin-black-light' => 'skin-black-light',
                        'skin-red-light' => 'skin-red-light',
                        'skin-yellow-light' => 'skin-yellow-light',
                        'skin-purple-light' => 'skin-purple-light',
                        'skin-green-light' => 'skin-green-light',
                    ],
                ],
                'backend.layout-fixed' => [
                    'label' => Yii::t('backend', 'Fixed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
                'backend.layout-boxed' => [
                    'label' => Yii::t('backend', 'Boxed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
                'backend.layout-collapsed-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
                'backend.layout-mini-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar mini'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
            ],
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('backend', 'Settings successfully saved.'));

            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }
}
