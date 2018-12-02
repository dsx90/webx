<?php

namespace common\modules\tehnic\models;


use common\modules\tehnic\models\query\TehnicOptionValueQuery;
use yii\validators\RequiredValidator;
/**
 * This is the model class for table "{{%tehnic_option_value}}".
 *
 * @property integer $id
 * @property integer $tehnic_id
 * @property integer $option_id
 * @property string $value
 *
 * @property Tehnic $tehnic
 * @property TehnicOption $tehnic0
 */
class TehnicOptionValue extends \yii\db\ActiveRecord
{
    /**
     * @var array
     */
    public $option;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tehnic_option_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tehnic_id', 'option_id'], 'integer'],
            [['value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['tehnic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tehnic::class, 'targetAttribute' => ['tehnic_id' => 'launch_id']],
            [['tehnic_id'], 'exist', 'skipOnError' => true, 'targetClass' => TehnicOption::class, 'targetAttribute' => ['tehnic_id' => 'option_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tehnic_id' => 'Tehnic ID',
            'option_id' => 'Option ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTehnic()
    {
        return $this->hasOne(Tehnic::class, ['launch_id' => 'tehnic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasOne(TehnicOption::class, ['option_id' => 'option_id']);
    }

    /**
     * @param $attribute
     */
    public function validateFiles($attribute)
    {
        $requiredValidator = new RequiredValidator();
        foreach ($this->$attribute as $index => $row) {
            $error = null;
            $requiredValidator->validate($row['title'], $error);
            if (!empty($error)) {
                $key = $attribute . '[' . $index . '][title]';
                $this->addError($key, $error);
            }
        }
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\query\TehnicOptionValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TehnicOptionValueQuery(get_called_class());
    }
}
