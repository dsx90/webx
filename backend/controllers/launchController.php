<?php
namespace backend\controllers;

use common\models\ContentType;
use common\models\Meta;
use common\models\Template;
use Yii;
use common\models\Launch;
use common\models\Visit;
use common\models\Like;

use backend\models\search\LaunchSearch;

use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LaunchController implements the CRUD actions for Launch model.
 */
class LaunchController extends Controller
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
     * Lists all Launch models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new LaunchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => null]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAll()
    {

        $searchModel = new LaunchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Launch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model =  $this->findModel($id);
        Visit::check($model->id);           // Фиксируем просмотр

        if ($model->template){
            $template = Template::find()->where(['id' => $model->template_id])->one();
            if ($template->load(Yii::$app->request->post()) && $template->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('document', 'Шаблон отредактирован.'));
            }
            if($model->template->display == Template::SHOW_PARTIAL){
                return $this->renderPartial('@template/'.$model->template->title.'.tpl', [
                    'model' => $model,
                ]);
            }
            return $this->render('view', [
                'model' => $model,
                'template' => $template
            ]);
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Публичное отображение документа
     * @param $alias - Url-адрес документа
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($slug)
    {
        // Отображаем только опубликованные документы
        $model = Launch::find()->where(['slug' => $slug, 'status' => Launch::STATUS_ACTIVE])->one();
        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('backend', 'Requested page was not found.'));
        }
        Visit::check($model->id);           // Фиксируем просмотр
        $visit = Visit::getAll($model->id); // Считаем просмотры
        $likes = Like::getAll($model->id);  // Считаем лайки
        // Если задан шаблон отображения, то отображаем согласно нему, иначе стандартное отображение статьи
        $template = (isset($model->template) && $model->template->path) ? $model->template->path : '@vendor/lowbase/yii2-document/views/document/template/default';
        return $this->render($template, [
            'model' => $model,
            'visit' => ($visit) ?  $visit[0]->count : 0,
            'likes' => ($likes) ?  $likes[0]->count : 0
        ]);
    }

    /**
     * Creates a new Launch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Launch();
        $meta = new Meta();

        // Устанавливаем родительский документ если пришло значение из $_GET
        $model->parent_id = Yii::$app->request->get('parent_id');

        if($model->parent->module){
            $model->content_type_id = ContentType::findOne(['key' => $model->parent->module['child']])->id;
        }

        // Заполняем необходимые для заполнения поля
        if ($model->load(Yii::$app->request->post()) && $model->save() && $meta->save()) {
            $model->link('meta', $meta);
            Yii::$app->getSession()->setFlash('success', Yii::t('bakend', 'A new document is created.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'meta' => $meta,
            ]);
        }
    }

    public function actionAjax($id)
    {
        $launch = $this->findModel($id);
        $meta   = Meta::findOne(['launch_id' => $id]);
        if( Yii::$app->request->isAjax){
            $launch->content_type_id = Yii::$app->request->post('content_type_id');
            $launch->save();
        }
        $module = $launch->module->model;
        if(($id) && $module::findOne($id) !== null){
            $model = $module::findOne($id);
        } else {
            $model = new $launch->module->model();
        }
        $render = $launch->module->form;
        return $this->renderAjax($render, [
            'model' => $model,
            'meta'  => $meta
        ]);
    }

    //Обработка события `распахивания` узла
    public function actionGetchilds() {

        $node_id = \Yii::$app->request->post('node_id');

        if ( !is_numeric( $node_id ) ) {
            $model =  Launch::find()
                ->andWhere(['is', 'parent_id', NULL])
                ->orderBy(['parent_id' => SORT_ASC, 'title' => SORT_ASC])->all();
        } else {
            $model =  Launch::find()
                ->where(['parent_id' => $node_id ])
                ->orderBy(['parent_id' => SORT_ASC, 'title' => SORT_ASC])->all();
        }
        $childsList = [];
        if ( $model !== null && is_array( $model ) && count( $model ) > 0 ) {
            foreach( $model as $item ) {
                $arr = [
                    'id' => $item->id,
                    'label' => $item->title
                ];
                if($item->children){
                    $arr['items'] = [];
                }
                $childsList[] = $arr;
            }
        }
        return Json::encode( $childsList );
    }

    //Обработка события `сворачивания` узла
    public function actionSetchilds($collapsed_node_id) {
        return Json::encode( [ 'id' => $collapsed_node_id ] );
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $meta   = Meta::findOne(['launch_id' => $id]);

        $request = Yii::$app->request;
        if ($request->isPjax && ($module = $request->get('module')) !== null) {
            $model->content_type_id = $module;
        }

        $searchModel = new LaunchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => $model->id]);

        if ($model->template){
            $template = Template::find()->where(['id' => $model->template_id])->one();
            if ($template->load(Yii::$app->request->post()) && $template->save()) {

                if ($request->isPost && $this->save($model)) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Document edited.'));
                }
            }
            return $this->render('update', [
                'model' => $model,
                'meta'  => $meta,
                'template' => $template,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            if ($request->isPost && $this->save($model)) {
                Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Document edited.'));
                return $this->redirect(['update', 'id' => $model->id]);
            };

            return $this->render('update', [
                'model' => $model,
                'meta' => $meta,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    protected function save(Launch &$model)
    {
        $result = false;
        $mod = $model->model;
        if ($model->load(Yii::$app->request->post())) {
            try {

                $transaction = $model::getDb()->beginTransaction();
                $module_old = $model->getOldAttribute('content_type_id');
                if($model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Launch сохранен'));
                } else {
                    Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Launch не сохранен'));
                };

                if ($mod && $module_old != $model->content_type_id) {
                    $mod->delete();
                    $mod = null;
                }
                $model->refresh();

                if ($model->content_type_id && !$mod) {
                    $module = Yii::$app->modules[$model->contentType->module]['class'];
                    $m = $module::layout()[$model->contentType->key]['model'];
                    $mod = new $m;
                }
                /** @var ActiveRecord $mod */
                if ($mod && $mod->load(Yii::$app->request->post())) {

                    if ($mod->isNewRecord){
                        echo '<pre>';
                        print_r($mod->launch_id);
                        echo '</pre>';
                        $mod->link('launch', $model);
                    } else {

                        $mod->save();
                    }
                }

                $result = true;
                $transaction->commit();

            } catch (\Exception $exception) {
                $transaction->rollBack();
                Yii::trace($exception);
            }
        }

        return $result;
    }

    /**
     * Изменение шаблона докуменат
     */
    public function actionChange()
    {
        $id = Yii::$app->request->post('id');
        $model = ($id) ? Launch::findOne($id) : new Launch();
        $model->template_id = Yii::$app->request->post('template_id');

        return $this->renderAjax('@vendor/lowbase/yii2-document/views/document/_fields', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Launch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) { // Если пришел Ajax-запрос
            return true;
        } else {
            Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'The document is deleted.'));
            return $this->redirect(['index']);
        }
    }

    /**
     * Лайк документа
     * Отображает количество лайков статьи
     * @param $id - ID документа
     * @return int|mixed
     */
    public function actionLike(int $id)
    {
        Like::check($id);
        $likes = Like::getAll($id);
        return ($likes) ? $likes[0]->count : 0;
    }

    /**
     * Finds the Launch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Launch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Launch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Множественное удаление документов
     */
    public function actionMultidelete()
    {
        $models = Yii::$app->request->post('keys');
        if ($models) {
            foreach ($models as $id) {
                $this->findModel($id)->delete();
            }
            Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Documents removed.'));
        }
        return true;
    }

    /**
     * Множественная публикация документов
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionMultiactive()
    {
        $models = Yii::$app->request->post('keys');
        if ($models) {
            foreach ($models as $id) {
                $model = $this->findModel($id);
                $model->status = Launch::STATUS_ACTIVE;
                $model->save();
            }
            Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Documents published.'));
        }
        return true;
    }

    /**
     * Множественное снятие с публикации документов
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionMultiblock()
    {
        $models = Yii::$app->request->post('keys');
        if ($models) {
            foreach ($models as $id) {
                $model = $this->findModel($id);
                $model->status = Launch::STATUS_DRAFT;
                $model->save();
            }
            Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Documents unpublished.'));
        }
        return true;
    }

    /**
     * Перемещение документа
     * Используется компонентом JSTree
     * @return bool
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionMove()
    {
        // Получаем данные необходимые для перемещения
        $data = Yii::$app->request->post();
        $model = $this->findModel($data['id']);
        // Запоминаем прошлый родительский документ
        $old_parent_id = $model->parent_id;
        // # - означает, что документ первого уровня (нет родителя)
        $model->parent_id = ($data['new_parent_id'] == '#') ? null : $data['new_parent_id'];

        // Если указан документ после которого надо поместить документ

        if ($data['new_prev_id'] && $data['new_prev_id'] !== 'false') {
            $prev_model = $this->findModel($data['new_prev_id']);
            $model->position = $prev_model->position+1;
        } else {
            $model->position = 0;
        }
        // Если указан документ перед которым надо поместить документ
        if ($data['new_next_id'] && $data['new_next_id'] !== 'false' && (!$data['new_prev_id'] || $data['new_prev_id'] == 'false')) {
            // Документов впереди на уровне нет
            $model->position = 0;
        }
        // Пересчитываем позиции остальных документов текущего уровня
        $db = $model->getDb();
        $transaction = $db->beginTransaction();
        try {
            $db->createCommand("set @i:=". $model->position)->execute();
            if ($model->parent_id) {
                $db->createCommand('UPDATE launch SET position=(@i:=@i+1) WHERE (parent_id='.$model->parent_id.' && `position`>='.$model->position.') ORDER BY position')->execute();
            } else {
                $db->createCommand('UPDATE launch SET position=(@i:=@i+1) WHERE (parent_id IS NULL && `position`>='.$model->position.') ORDER BY position')->execute();
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $model->save();

        // Пересматриваем пометку "Папка" если произошло изменение
        // родительского документа
        if ($old_parent_id <> $model->parent_id) {
            if ($old_parent_id !== '#') {
                // Проверяем необходимость снять пометки "Папка"
                // с прошлого родителя
                Launch::folder($old_parent_id);
            }
            if ($old_parent_id !== null) {
                // Устанавлием значение "Папка" на нового родителя
                // если не был установлен до этого
                Launch::folder($model->parent_id);
            }
        }
        return true;
    }
}
