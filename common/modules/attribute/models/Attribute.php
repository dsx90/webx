<?php

namespace common\modules\attribute\models;

use Yii;

/**
 * This is the model class for table "{{%attribute}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $scale
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
            [['type', 'max', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['scale'], 'string', 'max' => 3],
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
