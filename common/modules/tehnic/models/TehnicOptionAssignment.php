<?php

namespace common\modules\tehnic\models;

use dsx90\launcher\models\Launch;
use Yii;

/**
 * This is the model class for table "{{%tehnic_option_assignment}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $option_id
 *
 * @property Launch $category
 * @property TehnicOption $option
 */
class TehnicOptionAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tehnic_option_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'option_id'], 'required'],
            [['category_id', 'option_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Launch::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => TehnicOption::className(), 'targetAttribute' => ['option_id' => 'option_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'option_id' => 'Option ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Launch::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(TehnicOption::className(), ['option_id' => 'option_id']);
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\query\TehnicOptionAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\tehnic\models\query\TehnicOptionAssignmentQuery(get_called_class());
    }
}
