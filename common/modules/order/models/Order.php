<?php

namespace common\modules\order\models;

use yii\db\ActiveRecord;
use common\models\User;
use common\models\UserIp;
use common\modules\comment\models\Comment;
use common\modules\tehnic\models\TehnicCustomer;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string $table
 * @property int $link_id
 * @property int $user_ip_id
 * @property int $manager_id
 * @property int $comment_id
 * @property int $manager_comment_id
 * @property int $status
 * @property int $created_at
 * @property int $update_at
 *
 * @property Comment $comment
 * @property Comment $managerComment
 * @property User $manager
 * @property UserIp $userIp
 * @property TehnicCustomer[] $tehnicCustomers
 */
class Order extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table', 'link_id', 'user_ip_id'], 'required'],
            [['link_id', 'user_ip_id', 'manager_id', 'comment_id', 'manager_comment_id', 'status', 'created_at', 'update_at'], 'default', 'value' => null],
            [['link_id', 'user_ip_id', 'manager_id', 'comment_id', 'manager_comment_id', 'status', 'created_at', 'update_at'], 'integer'],
            [['table'], 'string', 'max' => 255],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::class, 'targetAttribute' => ['comment_id' => 'id']],
            [['manager_comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::class, 'targetAttribute' => ['manager_comment_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['manager_id' => 'id']],
            [['user_ip_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserIp::class, 'targetAttribute' => ['user_ip_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'table'                 => 'Table',
            'link_id'               => 'Link ID',
            'user_ip_id'            => 'User Ip ID',
            'manager_id'            => 'Manager ID',
            'comment_id'            => 'Comment ID',
            'manager_comment_id'    => 'Manager Comment ID',
            'status'                => 'Status',
            'created_at'            => 'Created At',
            'update_at'             => 'Update At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::class, ['id' => 'comment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManagerComment()
    {
        return $this->hasOne(Comment::class, ['id' => 'manager_comment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::class, ['id' => 'manager_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserIp()
    {
        return $this->hasOne(UserIp::class, ['id' => 'user_ip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTehnicCustomers()
    {
        return $this->hasMany(TehnicCustomer::class, ['customer_id' => 'id']);
    }
}
