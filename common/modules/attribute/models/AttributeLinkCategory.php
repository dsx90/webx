<?php

namespace common\modules\attribute\models;

use Yii;

/**
 * This is the model class for table "attribute_link_category".
 *
 * @property int $id
 * @property int $category_id
 * @property int $attribute_id
 * @property bool $visible
 * @property bool $filter
 *
 * @property Attribute $attribute0
 * @property Launch $category
 */
class AttributeLinkCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attribute_link_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'attribute_id'], 'required'],
            [['category_id', 'attribute_id'], 'default', 'value' => null],
            [['category_id', 'attribute_id'], 'integer'],
            [['visible', 'filter'], 'boolean'],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Launch::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'attribute_id' => 'Attribute ID',
            'visible' => 'Visible',
            'filter' => 'Filter',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Launch::className(), ['id' => 'category_id']);
    }
}
