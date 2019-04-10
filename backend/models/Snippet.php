<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%snippet}}".
 *
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $code
 * @property int $is_file
 * @property string $file
 *
 * @property Group $group
 */
class Snippet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%snippet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'is_file'], 'integer'],
            [['code'], 'string'],
            [['name', 'description', 'file'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'group_id' => Yii::t('backend', 'Group ID'),
            'name' => Yii::t('backend', 'Name'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'code' => Yii::t('backend', 'Code'),
            'is_file' => Yii::t('backend', 'Is File'),
            'file' => Yii::t('backend', 'File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }
}
