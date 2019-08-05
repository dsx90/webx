<?php

namespace common\modules\attribute\models;

use Yii;

/**
 * This is the model class for table "{{%attribute}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property integer $scale
 * @property bool $required
 * @property int $type
 * @property int $max
 * @property int $sort
 *
 * @property AttributeLinkCategory[] $attributeLinkCategories
 * @property AttributeValue[] $attributeValues
 * @property AttributeValueLaunch[] $attributeValueLaunches
 */
class Attribute extends \yii\db\ActiveRecord
{
    /** Валидация данных */
    /** @var int Для хранения чисел */
    const VALID_INTEGER  = 1;

    /** @var int Для хранения строк */
    const VALID_STRING   = 2;

    /** @var int Для хранения boolean */
    const VALID_BOOLEAN  = 3;

    /////
    /** @var int Для хранения Email */
    const VALID_EMAIL   = 3;

    /** @var int Для хранения Телефона */
    const VALID_PHONE   = 4;

    /** @var int Для хранения Кода */
    const VALID_CODE    = 5;


    /** Тип данных */
    /** @var int Длина */
    const TYPE_WIDTH   = 1;

    /** @var int Площадь*/
    const TYPE_AREA    = 2;

    /** @var int Множесвенные значения */
    const TYPE_ARRAY   = 3;

    /** @var int Множесвенные значения типа MIGX */
    const TYPE_MULTIPLE   = 3;


    /**
     * @return array
     */
    public static function getValidate()
    {
        return [
            self::VALID_INTEGER  => Yii::t('attribute', 'Integer'),
            self::VALID_STRING   => Yii::t('attribute', 'String'),
        ];
    }

    /**
     * @return array
     */
    public static function getType()
    {
        return [
            self::TYPE_WIDTH       => Yii::t('attribute', 'Width'),
            self::TYPE_AREA        => Yii::t('attribute', 'Area'),
            self::TYPE_ARRAY       => Yii::t('attribute', 'Array'),
            self::TYPE_MULTIPLE    => Yii::t('attribute', 'Multiple'),
        ];
    }

    /**
     * @return array
     */
    public static function getScaleValues()
    {
        return [
            self::SCALE_WIDTH => [
                'centimetr',
                'metre',
                'kilometer'
            ],
            self::SCALE_AREA => [
                'centimetr²',
                'metre²',
                'kilometer²'
            ],
            self::SCALE_ARRAY => [
                'color',
                'check',
                'radio',
                'dropdown',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attribute}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'scale'], 'required'],
            [['required'], 'boolean'],
            [['max', 'sort'], 'default', 'value' => null],
            [['type', 'max', 'sort','scale'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('attribute', 'ID'),
            'name'          => Yii::t('attribute', 'Name'),
            'description'   => Yii::t('attribute', 'Description'),
            'scale'         => Yii::t('attribute', 'Scale'),
            'required'      => Yii::t('attribute', 'Required'),
            'type'          => Yii::t('attribute', 'Type'),
            'max'           => Yii::t('attribute', 'Max'),
            'sort'          => Yii::t('attribute', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeLinkCategories()
    {
        return $this->hasMany(AttributeLinkCategory::class, ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::class, ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValueLaunches()
    {
        return $this->hasMany(AttributeValueLaunch::class, ['attribute_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\attribute\query\AttributeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\attribute\query\AttributeQuery(get_called_class());
    }
}
