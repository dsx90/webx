<?php

namespace common\models;

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
            [['sort'], 'default', 'value' => null],
            [['sort'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 50],
            [['key', 'description'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => Yii::t('common', 'Title'),
            'key' => Yii::t('common', 'Key'),
            'description' => Yii::t('common', 'Description'),
            'sort' => Yii::t('common', 'Sort'),
            'slug' => Yii::t('common', 'Slug'),
        ];
    }
}
