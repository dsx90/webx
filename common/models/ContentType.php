<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%content_type}}".
 *
 * @property integer $id
 * @property string $module
 * @property string $key
 * @property string $name
 * @property string $icon
 * @property string $status
 * @property string $params
 */
class ContentType extends ActiveRecord
{
    const STATUS_OFF= 0;
    const STATUS_ON = 1;

    const CACHE_KEY = 'launch_content_type';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'key'], 'required'],
            ['key', 'unique'],
            [['icon'], 'trim'],
            [['module', 'key', 'name', 'icon'], 'string'],
            ['status', 'boolean'],
            [['title', 'model', 'controller', 'form'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'model'         => 'Model',
            'controller'    => 'Controller',
            'form'          => 'Form',
        ];
    }

    public static function getTypes($el = null){
        $result = [];
        $types = self::find()
            ->where(['status' => true])
            ->all();
        ;
        foreach ($types as $type){
            foreach (Yii::$app->modules[$type->module]['class']::layout() as $key => $arr){

                $result[$type->id] = $el ? $arr[$el] : $arr;
            }
        }
        return $result;
    }

    public function getSection($key = null)
    {
        $result = Yii::$app->modules[$this->module]['class']::layout()[$this->key];
        return $key ? $result[$key] : $result;
    }
}
