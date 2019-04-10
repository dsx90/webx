<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%panel}}".
 *
 * @property int $id
 * @property int $context_id
 * @property string $title
 * @property string $description
 * @property string $key
 * @property int $status
 * @property int $sort
 * @property Context $context
 *
 * @property PanelItem[] $panelItems
 */
class Panel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%panel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['context_id', 'status', 'sort'], 'default', 'value' => null],
            [['context_id', 'status', 'sort'], 'integer'],
            [['title', 'key'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['key'], 'unique'],
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
            'context_id' => Yii::t('common', 'Context ID'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'key' => Yii::t('common', 'Key'),
            'status' => Yii::t('common', 'Status'),
            'sort' => Yii::t('common', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanelItems()
    {
        return $this->hasMany(PanelItem::class, ['panel_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContext(){
        return $this->hasOne(Context::class, ['id' => 'context_id']);
    }
}
