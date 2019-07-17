<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_ip}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $agent_id
 * @property string $IP
 *
 * @property Comment[] $comments
 * @property Event[] $events
 * @property Like[] $likes
 * @property Order[] $orders
 * @property User $user
 * @property UserAgent $agent
 * @property Visit[] $visits
 */
class UserIp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_ip}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'agent_id'], 'default', 'value' => null],
            [['user_id', 'agent_id'], 'integer'],
            [['IP'], 'string'],
            [['user_id', 'agent_id', 'IP'], 'unique', 'targetAttribute' => ['user_id', 'agent_id', 'IP']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['agent_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAgent::className(), 'targetAttribute' => ['agent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'agent_id' => 'Agent ID',
            'IP' => 'Ip',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_ip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['user_ip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::className(), ['user_ip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_ip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(UserAgent::className(), ['id' => 'agent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(Visit::className(), ['user_ip_id' => 'id']);
    }
}
