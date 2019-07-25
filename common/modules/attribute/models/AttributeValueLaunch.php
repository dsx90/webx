<?php

namespace common\modules\attribute\models;

use common\models\Launch;
use Yii;

/**
 * This is the model class for table "{{%attribute_value_launch}}".
 *
 * @property int $launch_id
 * @property int $attribute_id
 * @property int $value_id
 *
 * @property Attribute $attribute0
 * @property AttributeValue $value
 * @property Launch $launch
 */
class AttributeValueLaunch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attribute_value_launch}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['launch_id', 'attribute_id', 'value_id'], 'default', 'value' => null],
            [['launch_id', 'attribute_id', 'value_id'], 'integer'],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::class, 'targetAttribute' => ['attribute_id' => 'id']],
            [['value_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeValue::class, 'targetAttribute' => ['value_id' => 'id']],
            [['launch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Launch::class, 'targetAttribute' => ['launch_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'launch_id' => 'Launch ID',
            'attribute_id' => 'Attribute ID',
            'value_id' => 'Value ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(Attribute::class, ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(AttributeValue::class, ['id' => 'value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLaunch()
    {
        return $this->hasOne(Launch::class, ['id' => 'launch_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\attribute\query\AttributeValueLaunchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\attribute\query\AttributeValueLaunchQuery(get_called_class());
    }
}
