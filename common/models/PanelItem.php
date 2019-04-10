<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%panel_item}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $panel_id
 * @property string $visible
 * @property string $title
 * @property string $description
 * @property string $icon
 * @property string $url
 * @property string $options
 * @property string $key
 * @property string $slug
 * @property int $sort
 * @property int $status
 * @property string $richtext
 *
 * @property Panel $panel
 * @property PanelItem $parent
 * @property PanelItem[] $panelItems
 */
class PanelItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%panel_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'panel_id', 'sort', 'status'], 'default', 'value' => null],
            [['parent_id', 'panel_id', 'sort', 'status'], 'integer'],
            [['richtext'], 'string'],
            [['visible', 'title', 'icon', 'url', 'key', 'slug'], 'string', 'max' => 50],
            [['description', 'options'], 'string', 'max' => 255],
            [['key'], 'unique'],
            [['slug'], 'unique'],
            [['url'], 'unique'],
            [['panel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Panel::className(), 'targetAttribute' => ['panel_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => PanelItem::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'parent_id' => Yii::t('common', 'Parent ID'),
            'panel_id' => Yii::t('common', 'Panel ID'),
            'visible' => Yii::t('common', 'Visible'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'icon' => Yii::t('common', 'Icon'),
            'url' => Yii::t('common', 'Url'),
            'options' => Yii::t('common', 'Options'),
            'key' => Yii::t('common', 'Key'),
            'slug' => Yii::t('common', 'Slug'),
            'sort' => Yii::t('common', 'Sort'),
            'status' => Yii::t('common', 'Status'),
            'richtext' => Yii::t('common', 'Richtext'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanel()
    {
        return $this->hasOne(Panel::class, ['id' => 'panel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(PanelItem::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanelItems()
    {
        return $this->hasMany(PanelItem::class, ['parent_id' => 'id']);
    }
}
