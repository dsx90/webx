<?php


namespace common\models;


use Yii;
use yii\db\ActiveRecord;

/**
 * Class Meta
 * @package common\models
 * This is the model class for table "{{%launch}}".
 *
 * @property string $title
 * @property string $long_title
 * @property string $description
 * @property string $keywords
 * @property string $menutitle
 * @property string $slug
 */

class Meta extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['slug', 'unique'],

            ['title',       'string', 'max' => 35],
            ['long_title',  'string', 'max' => 81],
            ['description', 'string', 'max' => 150],
            ['keywords',    'string', 'max' => 255],
            ['menutitle',   'string', 'max' => 20],
            ['slug',        'string', 'max' => 80],

            [['title', 'long_title', 'description', 'keywords', 'slug'], 'filter', 'filter' => 'trim'],  // Обрезаем строки по краям
            [['long_title', 'description', 'keywords'], 'default', 'value' => null], // По умолчанию = null
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title'             => Yii::t('common', 'Title'),
            'long_title'        => Yii::t('common', 'Long title'),
            'description'       => Yii::t('common', 'Description'),
            'keywords'          => Yii::t('common', 'Keywords'),
            'menutitle'         => Yii::t('common', 'Menutitle'),
            'slug'              => Yii::t('common', 'Slug'),
        ];
    }

    public function getLaunch()
    {
        return $this->hasOne(Launch::class, ['launch_id' => 'id']);
    }

}