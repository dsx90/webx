<?php

namespace common\modules\shop\models;

use yii\db\ActiveRecord;
use common\models\Launch;
use common\modules\shop\queries\ProductQuery;
use mirocow\eav\models\EavAttribute;
use Yii;
use mirocow\eav\models\EavAttributeValue;
use mirocow\eav\EavBehavior;

/**
 * This is the model class for table "{{%shop_product}}".
 *
 * @property int $launch_id
 * @property Launch $launch
 * @property string $content
 * @property int $price
 * @property int $old_price
 * @property int $status
 * @property EavAttribute $eavAttributes
 */
class Product extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * create_time, update_time to now()
     * crate_user_id, update_user_id to current login user id
     */
    public function behaviors()
    {
        return [
            'eav' => [
                'class' => EavBehavior::class,
                // это модель для таблицы object_attribute_value
                'valueClass' => EavAttributeValue::class,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['launch_id'], 'required'],
            [['launch_id', 'price', 'old_price', 'status'], 'integer'],
            [['content'], 'string'],
            [['launch_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'launch_id' => Yii::t('common', 'Launch ID'),
            'content'   => Yii::t('common', 'Content'),
            'price'     => Yii::t('common', 'Price'),
            'old_price' => Yii::t('common', 'Old Price'),
            'status'    => Yii::t('common', 'Status'),
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
    public function getEavAttributes()
    {
        return EavAttribute::find()
            ->where(['entityModel' => self::class])
            ->joinWith('entity')
            ->orderBy(['order' => SORT_ASC])
            ;
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}