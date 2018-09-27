<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property integer $manager_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $comment_manager
 * @property integer $status
 * @property integer $order_get
 * @property integer $debt
 * @property integer $debt_time
 * @property string $passport
 * @property string $company
 * @property integer $iin
 * @property integer $duration_time
 * @property string $thumbnail
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 *
 * @property User $manager
 * @property User $owner
 * @property TehnicCustomer[] $tehnicCustomers
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'manager_id', 'status', 'order_get', 'debt', 'debt_time', 'iin', 'duration_time'], 'integer'],
            [['comment', 'comment_manager'], 'string'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 18],
            [['passport', 'company', 'thumbnail', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 255],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['manager_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'owner_id'          => 'Owner ID',
            'manager_id'        => 'Manager ID',
            'name'              => 'Name',
            'phone'             => 'Phone',
            'email'             => 'Email',
            'comment'           => 'Comment',
            'comment_manager'   => 'Comment Manager',
            'status'            => 'Status',
            'order_get'         => 'Order Get',
            'debt'              => 'Debt',
            'debt_time'         => 'Debt Time',
            'passport'          => 'Passport',
            'company'           => 'Company',
            'iin'               => 'Iin',
            'duration_time'     => 'Duration Time',
            'thumbnail'         => 'Thumbnail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTehnicCustomers()
    {
        return $this->hasMany(TehnicCustomer::className(), ['customer_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CustomerQuery(get_called_class());
    }
}
