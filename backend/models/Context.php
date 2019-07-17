<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%context}}".
 *
 * @property int $id
 * @property string $title
 * @property string $key
 * @property string $description
 * @property int $sort
 * @property string $slug
 *
 * @property ContextKey[] $contextKeys
 */
class Context extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%context}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 50],
            [['key', 'description'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'title' => Yii::t('backend', 'Title'),
            'key' => Yii::t('backend', 'Key'),
            'description' => Yii::t('backend', 'Description'),
            'sort' => Yii::t('backend', 'Sort'),
            'slug' => Yii::t('backend', 'Slug')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContextKeys()
    {
        return $this->hasMany(ContextKey::class, ['context_id' => 'id']);
    }
}
