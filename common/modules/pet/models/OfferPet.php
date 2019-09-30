<?php

namespace common\modules\pet\models;

use common\models\Offer;
use Yii;

/**
 * This is the model class for table "{{%offer_pet}}".
 *
 * @property int $offer_id
 * @property int $pet_id
 * @property int $status
 *
 * @property Offer $offer
 * @property Pet $pet
 */
class OfferPet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%offer_pet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offer_id', 'pet_id', 'status'], 'default', 'value' => null],
            [['offer_id', 'pet_id', 'status'], 'integer'],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::class, 'targetAttribute' => ['offer_id' => 'id']],
            [['pet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::class, 'targetAttribute' => ['pet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'offer_id' => Yii::t('app', 'Offer ID'),
            'pet_id' => Yii::t('app', 'Pet ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffer()
    {
        return $this->hasOne(Offer::class, ['id' => 'offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPet()
    {
        return $this->hasOne(Pet::class, ['id' => 'pet_id']);
    }
}
