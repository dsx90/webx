<?php

namespace common\modules\construction\models;

use common\fields\Attachment;
use dsx90\launcher\models\Launch;
use fbalabanov\filekit\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "{{%construction}}".
 *
 * @property integer $launch_id
 * @property string $content
 * @property integer $price
 *
 * @property Launch $launch
 */
class Construction extends \yii\db\ActiveRecord
{

    public $attachment;

    public $class;

    /**
     * @inheritdoc
     */
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
    public static function tableName()
    {
        return '{{%construction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['launch_id'], 'required'],
            [['launch_id', 'price'], 'integer'],
            [['content'], 'string'],
            ['class', 'default', 'value' => get_class($this)],
            [['launch_id'], 'unique'],
            [['launch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Launch::className(), 'targetAttribute' => ['launch_id' => 'id']],
            [['attachment','class'], 'safe'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['launch_id' => 'launch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLaunch()
    {
        return $this->hasOne(Launch::className(), ['id' => 'launch_id']);
    }

    /**
     * @inheritdoc
     * @return \common\modules\construction\queries\ConstructionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\construction\queries\ConstructionQuery(get_called_class());
    }
}
