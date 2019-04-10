<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%context_key}}".
 *
 * @property int $id
 * @property int $context_id
 * @property string $title
 * @property string $description
 * @property string $key
 * @property string $value
 *
 * @property Context $context
 */
class ContextKey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%context_key}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['context_id'], 'integer'],
            [['value'], 'string'],
            [['title', 'key'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['context_id'], 'exist', 'skipOnError' => true, 'targetClass' => Context::class, 'targetAttribute' => ['context_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'context_id' => Yii::t('backend', 'Context ID'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'key' => Yii::t('backend', 'Key'),
            'value' => Yii::t('backend', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContext()
    {
        return $this->hasOne(Context::class, ['id' => 'context_id']);
    }
}
