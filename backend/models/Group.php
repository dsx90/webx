<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property int $id
 * @property string $title
 *
 * @property Chunk[] $chunks
 * @property Snippet[] $snippets
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChunks()
    {
        return $this->hasMany(Chunk::class, ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippets()
    {
        return $this->hasMany(Snippet::class, ['group_id' => 'id']);
    }
}
