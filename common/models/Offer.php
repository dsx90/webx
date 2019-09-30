<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%offer}}".
 *
 * @property int $id
 * @property string $price
 * @property int $create_at
 *
 * @property OfferPet[] $offerPets
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%offer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['create_at'], 'default', 'value' => null],
            [['create_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'price' => Yii::t('app', 'Price'),
            'create_at' => Yii::t('app', 'Create At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferPets()
    {
        return $this->hasMany(OfferPet::className(), ['offer_id' => 'id']);
    }
}
