<?php

namespace common\models;

use backend\models\Chunk;
use backend\models\Snippet;
use common\models\query\LaunchQuery;
use hiqdev\composer\config\configs\Params;
use Yii;
use yii\base\View;
use yii\base\ViewEvent;
use yii\base\ViewRenderer;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%launch}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $long_title
 * @property string $description
 * @property string $keywords
 * @property string $menutitle
 * @property string $slug
 * @property integer $status
 * @property string $content_type_id
 * @property integer $author_id
 * @property integer $updater_id
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $template_id
 * @property integer $position
 *
 * @property integer $children
 * @property boolean is_folder
 *
 * @property User $author
 * @property User $updater
 */
class Launch extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT      = 0; // Скрыт
    const STATUS_ACTIVE     = 1; // Активен
    const STATUS_WAIT       = 3; // На модерации

    /**
     * Статусы документов
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_DRAFT      => Yii::t('backend', 'Draft'),
            self::STATUS_ACTIVE     => Yii::t('backend', 'Active'),
            self::STATUS_WAIT       => Yii::t('backend', 'Wait'),
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%launch}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['slug', 'unique'],
            [['parent_id', 'is_folder', 'position', 'status', 'author_id', 'updater_id', 'published_at', 'created_at', 'updated_at', 'content_type_id'], 'integer'],
            ['published_at', 'default', 'value' => time()],

            ['title', 'string', 'max' => 35],
            ['long_title', 'string', 'max' => 81],
            ['description', 'string', 'max' => 150],
            ['keywords', 'string', 'max' => 255],
            ['menutitle', 'string', 'max' => 20],
            ['slug', 'string', 'max' => 80],

            [['title', 'long_title', 'description', 'keywords', 'slug'], 'filter', 'filter' => 'trim'],  // Обрезаем строки по краям
            [['long_title', 'description', 'keywords', 'parent_id', 'template_id', 'position'], 'default', 'value' => null], // По умолчанию = null
            ['status', 'in', 'range' => array_keys(self::getStatusArray())],    // Статус должен быть из списка статусов
            [['is_folder'], 'default', 'value' => 0],                           // По умолчанию не папка, а документ
            [['status'], 'default', 'value' => self::STATUS_DRAFT],             // По умолчанию статус "Опубликован"

            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass'   => self::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::class, 'targetAttribute' => ['template_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass'   => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass'  => User::class, 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('common', 'ID'),
            'parent_id'         => Yii::t('common', 'Parent ID'),
            'title'             => Yii::t('common', 'Title'),
            'long_title'        => Yii::t('common', 'Long title'),
            'description'       => Yii::t('common', 'Description'),
            'keywords'          => Yii::t('common', 'Keywords'),
            'menutitle'         => Yii::t('common', 'Menutitle'),
            'slug'              => Yii::t('common', 'Slug'),
            'status'            => Yii::t('common', 'Status'),
            'content_type_id'   => Yii::t('common', 'Content type'),
            'author_id'         => Yii::t('common', 'Author ID'),
            'updater_id'        => Yii::t('common', 'Updater ID'),
            'published_at'      => Yii::t('common', 'Published At'),
            'created_at'        => Yii::t('common', 'Created At'),
            'updated_at'        => Yii::t('common', 'Updated At'),
            'template_id'       => Yii::t('common', 'Template Id'),
        ];
    }

    /**
     * Tип контента
     * @return \yii\db\ActiveQuery
     */
    public function getContenttype(){
        return $this->hasOne(ContentType::class, ['id' => 'content_type_id']);
    }

    /**
     * Шаблон документа
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['id' => 'template_id']);
    }

    /**
     * Лайки
     * @return \yii\db\ActiveQuery
     */
    public function getVisit()
    {
        return $this->hasOne(Visit::class, ['launch_id' => 'id'])->count();
    }

    /**
     * Лайки
     * @return \yii\db\ActiveQuery
     */
    public function getLike()
    {
        return $this->hasOne(Like::class, ['launch_id' => 'id'])->count();
    }

    /**
     * Подключение модели выбранного модуля
     * @return null|\yii\db\ActiveQuery
     */
    public function getModels()
    {
        if (!$this->content_type_id) return null;
        return $this->hasOne($this->contenttype->model::className(), ['launch_id' => 'id']);

    }

    /**
     * @param $name
     * @return mixed
     */
    public function getChunk($name)
    {
        // TODO: Не работает Smarty
        return Chunk::find()->where(['name' => $name])->one()  ;
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     */
    public function getSnippet($name, $params = [])
    {
        extract($params, EXTR_OVERWRITE);
        $snippet = Snippet::find()->where(['name' => $name])->one()->code;
        return \Yii::$app->view->renderDynamic($snippet);
    }

    /**
     * Поллучить ссыки на предидущий | следуюший ресурс
     * @return mixed|null
     */
    public function getNext() {
        $next = $this->find()
            ->where(['parent_id' => $this->parent_id])
            ->andWhere(['>', 'id', $this->id])
            ->orderBy('id asc')
            ->one();

        if (isset($next))
            return $next->id;
        else return null;
    }

    public function getPrev() {
        if($this->id == '1') return null;
        else
        {
            $prev = $this->find()
                ->where(['parent_id' => $this->parent_id])
                ->andWhere(['<', 'id', $this->id])
                ->orderBy('id desc')
                ->one();

            if (isset($prev)) {
                return $prev->id;
            } else {return null;}
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Родительский документ
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * Дочерние документы
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * Просмотры документа
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(Visit::class, ['launch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updater_id']);
    }

    /**
    * Получить список документов массивом
    * @param null $parent_id - родительский документ
    * @return array [ID => Название]
    */
    public static function getAll($parent_id = null, $url = null)
    {
        $parent = [];
        $query = self::find();
        if ($parent_id) {
            $query = $query->andWhere(['parent_id' => $parent_id]);
        }
        if ($url) {
            $query = $query->with('childs');
        }

        if ($models = $query->all()) {
            if (isset($url)){
                foreach ($models as $m) {
                    $items[$m->id] = [
                        'url' => [$url, 'slug' => $m->slug],
                        'label' => $m->title,
                        'items' => self::getMenuItems($m->childs),
                    ];
                }
            } else{
                foreach ($models as $m) {
                    $parent[$m->id] = $m->title;
                }
            }
        }
        return $parent;
    }

    /**
     * Пометка или снятие документа как папки
     * @param $id - ID документа
     * @param bool $child_delete - дочерние документы удаляются?
     * @throws \yii\db\Exception
     */
    public static function folder($id, $child_delete = false)
    {
        $model  = self::findOne($id);
        $db     = self::getDb();
        // Помечаем документ как папку если имеются дочерние документы
        if ($model && $model->children && !$model->is_folder) {
            $db->createCommand()->update('launch', ['is_folder' => 1], ['id' => $model->id])->execute();
        }
        // Помечаем папку как документ если нет дочерних документов или
        // имеется один дочерний докуемнт, который будет удален
        if (($model && !$model->children && $model->is_folder) ||
            ($model && count($model->children) === 1 && $model->is_folder && $child_delete)) {
            $db->createCommand()->update('launch', ['is_folder' => 0], ['id' => $model->id])->execute();
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool|void
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // Пометка "Папкой" текущего документа при необходимости
        self::folder($this->parent_id);
        // Пометка "Папкой" родительского документа при необходимости
        if (isset($changedAttributes['parent_id'])) {
            self::folder($changedAttributes['parent_id']);
        }
        //$this->fieldsSave();
        return true;
    }

    /**
     * Перед удалением проверяем количество дочерних
     * документов у родительского документа.
     * Если это был единственный документ, то у родителя
     * снимаем значение "Папка"
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        // Снятие значения "Папка" у родительского документа при необходимости
        self::folder($this->parent_id, true);
        return true;
    }

    /**
     * Перед сохранением документа выставляем
     * ему необходимую позицию, инкрементируя последнюю
     * позицию из текущей директории
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && !$this->position) {
                $model = self::find()
                    ->select(['position'])
                    ->where(['parent_id' => $this->parent_id])
                    ->orderBy(['position' => SORT_DESC])
                    ->one();
                $this->position = ($model && $model->position) ? $model->position+1 : 1;
            }
            return true;
        }
        return false;
    }


    public static function find()
    {
        return new LaunchQuery(get_called_class());
    }

}