<?php

namespace backend\models;

use common\models\PanelItem;
use Yii;

/**
 * This is the model class for table "{{%panel}}".
 *
 * @property int $id
 * @property int $context_id
 * @property string $title
 * @property string $description
 * @property string $key
 * @property int $sort
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
            [['context_id', 'sort'], 'integer'],
            [['title', 'key'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['key'], 'unique'],
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
            'sort' => Yii::t('backend', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanelItems()
    {
        return $this->hasMany(PanelItem::class, ['panel_id' => 'id']);
    }
}
