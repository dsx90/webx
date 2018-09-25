<?php

namespace common\modules\tehnic\controllers\frontend;

use common\models\Launch;
use common\models\UserProfile;
use common\modules\tehnic\models\Tehnic;
use common\modules\tehnic\models\TehnicCat;
use common\modules\tehnic\search\TehnicSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Tag;

/**
 * Class TehnicController.
 */
class TehnicController extends Controller
{
    public function actionIndex()
    {
        $launch = Launch::find();
        $searchModel = new TehnicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'launch' => $launch,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory($slug = null)
    {
        if ($slug !== null){
            $launch = Launch::find()->andWhere(['slug' => $slug])->one();
        } else {
            $launch = Launch::find();
        }

        $searchModel = new TehnicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('category', [
            'launch' => $launch,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'menuItems' => self::getMenuItems(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Tehnic();

        $categories = TehnicCat::find()->parents()->active()->all();
        $categories = ArrayHelper::map($categories, 'id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
                //'categories' => TehnicCat::find()->where(['not in', 'parent_id', 'NULL'])->active()->all(),
                'menuItems' => self::getMenuItems(),
            ]);
        }
    }

    public function actionUpdate($slug)
    {
        $launch = Launch::find()->andWhere(['slug' => $slug])->one();
        $model  = Tehnic::find()->where(['launch_id' => $launch->id])->one();
        
        $query = Launch::find()->joinWith('parent_id')->andWhere(['not', ['launch.slug' => $slug]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => 10],
        ]);

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
            'launch' => $launch,
            'autor' => UserProfile::find()->all(),
            'dataProvider' => $dataProvider,
            'menuItems' => self::getMenuItems(),
        ]);
    }

    public function actionView($slug)
    {
        $launch = Launch::find()->andWhere(['slug' => $slug])->one();
        $model  = Tehnic::find()->where(['launch_id' => $launch->id])->one();

        if (!$launch) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
        }

        //$query = Post::find()->with('tags')->joinWith('category')->where('{{%post_category}}.slug = :slug', [':slug' => $slug])->published();
        //$query = Tehnic::find()->joinWith('category')->andWhere(['not', ['post.slug' => $slug]])->published();
        $query = Launch::find()->joinWith('parent_id')->andWhere(['not', ['launch.slug' => $slug]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => 10],
        ]);

        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC],
        ];

        // meta keywords
        $this->getView()->registerMetaTag([
            'name' => 'description',
            'content' => $launch->description,
        ]);
        // meta description
        $this->getView()->registerMetaTag([
            'name' => 'keywords',
            'content' => $launch->keywords,
        ]);

        return $this->render('view', [
            'model' => $model,
            'launch' => $launch,
            'autor' => UserProfile::find()->all(),
            'dataProvider' => $dataProvider,
            'menuItems' => self::getMenuItems(),
        ]);
    }

    public function actionTag($slug)
    {
        $model = Tag::find()->andWhere(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
        }

        $query = Tehnic::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->published();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => 10],
        ]);

        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC],
        ];

        return $this->render('tag', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'menuItems' => self::getMenuItems(),
        ]);
    }

    public static function getMenuItems(array $models = null)
    {
        $items = [];
        if ($models === null) {
            $models = Launch::find()->where(['parent_id' => null])->with('children')->orderBy(['id' => SORT_ASC])->all();
        }
        foreach ($models as $model) {
            $items[] = [
                'url' => ['tehnic/category', 'slug' => $model->slug],
                'label' => $model->title,
                'items' => self::getMenuItems($model->children),
            ];
        }

        return $items;
    }
}

