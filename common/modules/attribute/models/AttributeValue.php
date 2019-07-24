<?php

namespace common\modules\attribute\models;

use Yii;

/**
 * This is the model class for table "{{%attribute_value}}".
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 *
 * @property Attribute $attribute0
 * @property AttributeValueLaunch[] $attributeValueLaunches
 */
class AttributeValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attribute_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attribute_id'], 'default', 'value' => null],
            [['attribute_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute_id' => 'Attribute ID',
            'value' => 'Value',
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
    public function getAttributeValueLaunches()
    {
        return $this->hasMany(AttributeValueLaunch::className(), ['value_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\attribute\query\AttributeValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\attribute\query\AttributeValueQuery(get_called_class());
    }
}
