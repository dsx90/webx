<?php

namespace common\modules\pet\models;

use common\components\LaunchActiveRecord;
use common\models\Launch;
use Yii;

/**
 * This is the model class for table "{{%pet}}".
 *
 * @property int $ties_id Связь родителей
 * @property bool $sex Пол
 * @property int $birth_date Дата рождения
 * @property int $status
 *
 * @property OfferPet[] $offerPets
 * @property TiesPets $ties
 * @property TiesPets[] $tiesPets
 * @property TiesPets[] $tiesPets0
 */
class Pet extends LaunchActiveRecord
{
    const SEX_FIMALE = 0;
    const SEX_MALE = 1;

    public static function sexTitle()
    {
        return [
            self::SEX_FIMALE    => 'Fimale',
            self::SEX_MALE      => 'Male'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ties_id', 'birth_date', 'status'], 'default', 'value' => null],
            [['ties_id', 'status'], 'integer'],
            [['sex'], 'boolean'],
            [['name'], 'string', 'max' => 80],
            [['description'], 'string', 'max' => 255],
            [['ties_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiesPets::class, 'targetAttribute' => ['ties_id' => 'id']],
            [['birth_date', 'launch_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ties_id'       => Yii::t('app', 'Ties ID'),
            'name'          => Yii::t('app', 'Name'),
            'description'   => Yii::t('app', 'Description'),
            'sex'           => Yii::t('app', 'Sex'),
            'birth_date'    => Yii::t('app', 'Birth Date'),
            'status'        => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferPets()
    {
        return $this->hasMany(OfferPet::class, ['pet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTies()
    {
        return $this->hasOne(TiesPets::class, ['id' => 'ties_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiesPets()
    {
        return $this->hasMany(TiesPets::class, ['male' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiesPets0()
    {
        return $this->hasMany(TiesPets::class, ['female' => 'id']);
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getBreed()
//    {
//        return $this->hasOne(Launch::class, ['id' => 'category_id'])
//            ->where([''])
//            ;
//    }
}
