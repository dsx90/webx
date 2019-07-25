<?php

namespace common\modules\attribute\models;

use Yii;

/**
 * This is the model class for table "{{%attribute}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property integer $scale
 * @property bool $required
 * @property int $type
 * @property int $max
 * @property int $sort
 *
 * @property AttributeLinkCategory[] $attributeLinkCategories
 * @property AttributeValue[] $attributeValues
 * @property AttributeValueLaunch[] $attributeValueLaunches
 */
class Attribute extends \yii\db\ActiveRecord
{
    const TYPE_INTEGER  = 1;
    const TYPE_STRING   = 2;

    const SCALE_WIDTH   = 1;
    const SCALE_AREA    = 2;

    public static function getType()
    {
        return [
            self::TYPE_INTEGER  => Yii::t('common', 'Integer'),
            self::TYPE_STRING   => Yii::t('common', 'String')
        ];
    }
    public static function getScale()
    {
        return [
            self::SCALE_WIDTH   => Yii::t('common', 'Width'),
            self::SCALE_AREA    => Yii::t('common', 'Area')
        ];
    }
    public static function getScaleValues()
    {
        return [
            self::SCALE_WIDTH => [
                'centimetr',
                'metre',
                'kilometer'
            ],
            self::SCALE_AREA => [
                'centimetr 2',
                'metre 2',
                'kilometer 2'
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attribute}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'scale'], 'required'],
            [['required'], 'boolean'],
            [['type', 'max', 'sort'], 'default', 'value' => null],
            [['type', 'max', 'sort','scale'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'scale' => 'Scale',
            'required' => 'Required',
            'type' => 'Type',
            'max' => 'Max',
            'sort' => 'Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeLinkCategories()
    {
        return $this->hasMany(AttributeLinkCategory::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValueLaunches()
    {
        return $this->hasMany(AttributeValueLaunch::className(), ['attribute_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\attribute\query\AttributeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\attribute\query\AttributeQuery(get_called_class());
    }
}
