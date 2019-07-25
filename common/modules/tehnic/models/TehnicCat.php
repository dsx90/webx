<?php

namespace common\modules\tehnic\models;

use common\models\query\CustomerQuery;
use common\modules\attribute\models\Attribute;
use common\modules\attribute\models\AttributeLinkCategory;
use fbalabanov\filekit\behaviors\UploadBehavior;
use Yii;
use common\models\Launch;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%tehnic_cat}}".
 *
 * @property integer $launch_id
 * @property string $content
 * @property string $thumbnail
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property Attribute[] $dynamicAttributes
 * @property Launch $launch
 */
class TehnicCat extends ActiveRecord
{
    public $thumbnail;
    public $attributesForm;
    public $scale;
    public $category;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tehnic_cat}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['launch_id'], 'integer'],
            [['content'], 'string'],
            [['thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 255],
            [['launch_id'], 'unique'],
            [['launch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Launch::class, 'targetAttribute' => ['launch_id' => 'id']],
            [['thumbnail', 'option', 'scale', 'category'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'launch_id'             => Yii::t('common', 'Launch ID'),
            'content'               => Yii::t('common', 'Content'),
            'thumbnail'             => Yii::t('common', 'Thumbnail'),
            'thumbnail_base_url'    => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path'        => Yii::t('common', 'Thumbnail Path'),
            'option'                => Yii::t('common', 'Options'),
            'category'              => Yii::t('common', 'Category Assignment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLaunch()
    {
        return $this->hasOne(Launch::class, ['id' => 'launch_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeLinks()
    {
        return $this->hasMany(AttributeLinkCategory::class, ['category_id' => 'launch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDynamicAttributes()
    {
        return $this->hasMany(Attribute::class, ['attribute_id' => 'id'])->via('attributesCat');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete()){
            AttributeLinkCategory::deleteAll(['id' => $this->launch_id]);
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        $this->option = ArrayHelper::map($this->dynamicAttributes, 'attribute_id', 'option');
        $this->scale = ArrayHelper::map($this->dynamicAttributes, 'attribute_id', 'scale');
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if(is_array($this->attributesForm)){
            $attributes = ArrayHelper::map($this->dynamicAttributes, 'option','attribute_id');
            foreach ($this->attributesForm as $new_attribute){
                if(isset($attributes[$new_attribute])){
                    unset($attributes[$new_attribute]);
                } else {
                    $this->createNewAttribute($new_attribute);
                }
            }
            AttributeLinkCategory::deleteAll(['and',['category_id' => $this->launch_id], ['option_id' => $attributes]]); // Удаление опции в связи
        } else {
            AttributeLinkCategory::deleteAll(['category_id' => $this->launch_id]);
        }
    }

    private function createNewAttribute($new_attribute){
        if(!Attribute::find()->andWhere(['name' => $new_attribute])->exists()){
            $attribute = new Attribute();
            $attribute->name = $new_attribute;
            if(!$attribute->save()){
                $attribute = null;
            }
        }
        if ($new_attribute instanceof Attribute){
            $link = new AttributeLinkCategory();
            $link->category_id = $this->launch_id;
            $link->attribute_id = $new_attribute->id;
            if($link->save())
                return $link->attribute_id;
        }
        return false;
    }

    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.//
     */
    public static function find()
    {
        return new \common\models\query\CustomerQuery(get_called_class());
    }
}
