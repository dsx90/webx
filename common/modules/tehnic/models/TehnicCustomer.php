<?php

namespace common\modules\tehnic\models;

use common\models\Customer;
use Yii;

/**
 * This is the model class for table "{{%tehnic_customer}}".
 *
 * @property integer $customer_id
 * @property integer $order_id
 * @property string $address
 * @property integer $work_time
 * @property integer $order_time
 * @property integer $order_on_time
 * @property integer $value_work
 * @property integer $percent
 *
 * @property Customer $customer
 * @property Tehnic $order
 */
class TehnicCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tehnic_customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'order_id', 'work_time', 'order_time', 'order_on_time', 'value_work', 'percent'], 'integer'],
            [['address'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tehnic::className(), 'targetAttribute' => ['order_id' => 'launch_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'order_id' => 'Order ID',
            'address' => 'Address',
            'work_time' => 'Work Time',
            'order_time' => 'Order Time',
            'order_on_time' => 'Order On Time',
            'value_work' => 'Value Work',
            'percent' => 'Percent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Tehnic::className(), ['launch_id' => 'order_id']);
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\query\TehnicCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\tehnic\models\query\TehnicCustomerQuery(get_called_class());
    }
}
