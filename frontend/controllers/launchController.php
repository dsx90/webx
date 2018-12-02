<?php
namespace frontend\controllers;

use Yii;
use common\models\Launch;
use common\models\Visit;
use common\models\Like;

use backend\models\search\LaunchSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LaunchController implements the CRUD actions for Launch model.
 */
class LaunchController extends Controller
{
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
        $views = Visit::getAll($model->id); // Считаем просмотры
        $likes = Like::getAll($model->id);  // Считаем лайки
        // Если задан шаблон отображения, то отображаем согласно нему, иначе стандартное отображение статьи
        $template = (isset($model->template) && $model->template->path) ? $model->template->path : '@vendor/lowbase/yii2-document/views/document/template/default';
        return $this->render($template, [
            'model' => $model,
            'views' => ($views) ?  $views[0]->count : 0,
            'likes' => ($likes) ?  $likes[0]->count : 0
        ]);
    }

    /**
     * Лайк документа
     * @param $id - ID документа
     * Отображает количество лайков статьи
     */
    public function actionLike($id)
    {
        Like::check($id);
        $likes = Like::getAll($id);
        echo ($likes) ? $likes[0]->count : 0;
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
}
