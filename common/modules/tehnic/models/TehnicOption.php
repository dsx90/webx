<?php

namespace common\modules\tehnic\models;

use kartik\builder\TabularForm;
use Yii;

/**
 * This is the model class for table "{{%tehnic_option}}".
 *
 * @property integer $option_id
 * @property string $option
 * @property string $scale
 *
 * @property TehnicOptionAssignment[] $tehnicOptionAssignments
 * @property TehnicOptionValue[] $tehnicOptionValues
 */
class TehnicOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tehnic_option}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option', 'scale'], 'required'],
            [['option', 'scale'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => 'Option ID',
            'option' => 'Option',
            'scale' => 'Scale',
        ];
    }

    public function getSelectName()
    {
        return $this->option . ', ' . $this->scale;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTehnicOptionAssignments()
    {
        return $this->hasMany(TehnicOptionAssignment::className(), ['option_id' => 'option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTehnicOptionValues()
    {
        return $this->hasMany(TehnicOptionValue::className(), ['tehnic_id' => 'option_id']);
    }
    public function getFormAttribs() {
        return [
            'option'=>['type'=>TabularForm::INPUT_TEXT],
            'scale'=>['type'=>TabularForm::INPUT_TEXT],
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\query\TehnicOptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\tehnic\models\query\TehnicOptionQuery(get_called_class());
    }
}
