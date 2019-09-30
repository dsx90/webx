<?php

namespace common\modules\pet\models;

use Yii;

/**
 * This is the model class for table "{{%ties_pets}}".
 *
 * @property int $id
 * @property int $male Самка
 * @property int $female Самец
 * @property int $data
 *
 * @property Pet[] $pets
 * @property Pet $male0
 * @property Pet $female0
 */
class TiesPets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ties_pets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['male', 'female', 'data'], 'default', 'value' => null],
            [['male', 'female', 'data'], 'integer'],
            [['male'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::className(), 'targetAttribute' => ['male' => 'id']],
            [['female'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::className(), 'targetAttribute' => ['female' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'male' => Yii::t('app', 'Male'),
            'female' => Yii::t('app', 'Female'),
            'data' => Yii::t('app', 'Data'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPets()
    {
        return $this->hasMany(Pet::className(), ['ties_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMale0()
    {
        return $this->hasOne(Pet::className(), ['id' => 'male']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFemale0()
    {
        return $this->hasOne(Pet::className(), ['id' => 'female']);
    }
}
