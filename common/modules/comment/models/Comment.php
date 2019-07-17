<?php

namespace common\modules\comment\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $table
 * @property int $link_id
 * @property int $user_ip_id
 * @property string $text
 * @property int $created_at
 *
 * @property Comment $parent
 * @property Comment[] $comments
 * @property UserIp $userIp
 * @property Order[] $orders
 * @property Order[] $orders0
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'link_id', 'user_ip_id', 'created_at'], 'default', 'value' => null],
            [['parent_id', 'link_id', 'user_ip_id', 'created_at'], 'integer'],
            [['table', 'link_id', 'user_ip_id'], 'required'],
            [['table', 'text'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['user_ip_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserIp::className(), 'targetAttribute' => ['user_ip_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'table' => 'Table',
            'link_id' => 'Link ID',
            'user_ip_id' => 'User Ip ID',
            'text' => 'Text',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comment::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserIp()
    {
        return $this->hasOne(UserIp::className(), ['id' => 'user_ip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['comment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasMany(Order::className(), ['manager_comment_id' => 'id']);
    }
}
