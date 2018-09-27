<?php

namespace common\modules\tehnic\models;

use Yii;

/**
 * This is the model class for table "{{%tehnic_cat_assignment}}".
 *
 * @property integer $id
 * @property integer $category
 * @property integer $subcategory
 *
 * @property TehnicCat $category0
 * @property TehnicCat $category1
 */
class TehnicCatAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tehnic_cat_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'subcategory'], 'required'],
            [['category', 'subcategory'], 'integer'],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => TehnicCat::class, 'targetAttribute' => ['category' => 'launch_id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => TehnicCat::class, 'targetAttribute' => ['category' => 'launch_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TehnicCat::class, ['launch_id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory1()
    {
        return $this->hasOne(TehnicCat::class, ['launch_id' => 'category']);
    }
}
