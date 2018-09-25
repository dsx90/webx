<?php

namespace common\modules\tehnic\models;

use common\fields\Attachment;
use common\models\query\CustomerQuery;
use common\modules\tehnic\models\query\TehnicQuery;
use fbalabanov\filekit\behaviors\UploadBehavior;
use Yii;
use common\models\Launch;
use common\components\Model;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%tehnic}}".
 *
 * @property integer $parent_id
 * @property integer $launch_id
 * @property string $content
 * @property integer $price
 * @property integer $status
 * @property integer $views
 *
 * @property Attachment[] $attachment
 * @property Launch $launch
 * @property TehnicCustomer[] $tehnicCustomers
 * @property TehnicOptionValue[] $tehnicOptionValues
 *
 * @property TehnicOptionValue[] $options
 */
class Tehnic extends \yii\db\ActiveRecord
{
    const TEHNIC_ACTIVE = 0;
    const TEHNIC_WORK = 1;
    const TEHNIC_REPAIR = 2;
    const TEHNIC_SELL = 3;

    public static $statuses = [
        self::TEHNIC_ACTIVE  => 'Ожидание заказа',
        self::TEHNIC_WORK    => 'Занята',
        self::TEHNIC_REPAIR  => 'На ремонте',
        self::TEHNIC_SELL    => 'Продам'
    ];

    public $attachment;
    public $option;
    public $value;
    public $scale;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tehnic}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachment',
                'multiple' => true,
                'uploadRelation' => 'attachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'sequence',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['launch_id', 'price', 'status', 'views'], 'integer'],
            [['content'], 'string'],
            [['launch_id'], 'unique'],
            ['status', 'default', 'value' => self::TEHNIC_ACTIVE],
            [['launch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Launch::className(), 'targetAttribute' => ['launch_id' => 'id']],
            [['attachment'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'launch_id' => Yii::t('common', 'Launch ID'),
            'content'   => Yii::t('common', 'Content'),
            'price'     => Yii::t('common', 'Price'),
            'status'    => Yii::t('common', 'Status'),
            'views'     => Yii::t('common', 'Views'),
            'attachment'=> Yii::t('common', 'Attachments')
        ];
    }

    public function getOptionForm(){
        return !$this->options ? [new TehnicOptionValue] : $this->options;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLaunch()
    {
        return $this->hasOne(Launch::className(), ['id' => 'launch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(TehnicCat::className(), ['launch_id' => 'parent_id'])->via('launch');
            //->viaTable('post_options_value', ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions() {
        return $this->hasMany(TehnicOptionValue::className(), ['tehnic_id' => 'launch_id']);
    }

    public function getFetchOptions() {
        return !$this->options ? [new TehnicOptionValue()] : $this->options;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments() {
        return $this->hasMany(Attachment::className(), ['launch_id' => 'launch_id']);
    }

    public function getImage($width ,$height ) {
        if($this->attachment) {
            foreach ($this->attachment as $attaching) {
                return Html::img(\common\lib\Imager::thumbnail($attaching['path'], $width, $height));
            }
        }
    }

    public function getAttribut($shift = ',') {
        $attribute = [];

        foreach ($this->options as $option){
            $attribute[] = $option->options->option.': '.$option->value.' '.$option->options->scale;
        }
        return implode($shift, $attribute);
    }

    /**
     * @return bool
     */
    public function saveRelation()
    {
        if($valid = $this->validate()) {
            /** @var TehnicOptionValue[] $options */
            $options = $this->options;
            $oldIDs = ArrayHelper::map($options, 'id', 'id');
            $options = Model::createMultiple(TehnicOptionValue::className(), $options, 'option');
            $post = Yii::$app->request->post('TehnicOptionValue');
            Model::loadMultiple($options, $post['option']);

            if(Model::validateMultiple($options) && $valid) {
                $deletedIDs = array_diff($oldIDs, array_keys(ArrayHelper::map($options, 'id', 'id')));
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (Model::validateMultiple($options)) {
                        if (!empty($deletedIDs)) {
                            TehnicOptionValue::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($options as $option) {
                            $option->tehnic_id = $this->launch_id;
                            if (!$option->save(false)) {
                                throw new \Exception(current(current($option->getErrors())));
                            }
                        }
                        $transaction->commit();
                        return true;
                    }
                } catch (\Exception $e) {
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                    $transaction->rollBack();
                    return false;
                }
            }
        }
        return false;
    }

    function cut($string, $length){
        $string = mb_substr($string, 0, $length,'UTF-8'); // обрезаем и работаем со всеми кодировками и указываем исходную кодировку
        $position = mb_strrpos($string, ' ', 'UTF-8'); // определение позиции последнего пробела. Именно по нему и разделяем слова
        $string = mb_substr($string, 0, $position, 'UTF-8'); // Обрезаем переменную по позиции
        return $string;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTehnicCustomers()
    {
        return $this->hasMany(TehnicCustomer::className(), ['order_id' => 'launch_id']);
    }

    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        //return new \common\models\query\CustomerQuery(get_called_class());
        return new TehnicQuery(get_called_class());
    }
}
