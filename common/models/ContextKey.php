<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%context_key}}".
 *
 * @property int $id
 * @property int $context_id
 * @property string $namespace
 * @property string $title
 * @property string $description
 * @property string $key
 * @property string $value
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
            [['context_id'], 'default', 'value' => null],
            [['context_id'], 'integer'],
            [['value'], 'string'],
            [['namespace', 'title', 'key'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'context_id'    => Yii::t('common', 'Context ID'),
            'namespace'     => Yii::t('common', 'Namespace'),
            'title'         => Yii::t('common', 'Title'),
            'description'   => Yii::t('common', 'Description'),
            'key'           => Yii::t('common', 'Key'),
            'value'         => Yii::t('common', 'Value'),
        ];
    }

    public function getContext()
    {
        return $this->hasOne(Context::class, ['id' => 'context_id']);
    }
}
