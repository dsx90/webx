<?php

namespace common\fields;

use common\models\Launch;
use Yii;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property integer $id
 * @property integer $launch_id
 * @property string $path
 * @property string $base_url
 * @property string $type
 * @property integer $size
 * @property string $name
 * @property integer $create_at
 *
 * @property Launch $launch
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['launch_id', 'size', 'create_at', 'sequence'], 'integer'],
            [['path', 'base_url', 'type', 'name'], 'string', 'max' => 255],
            [['launch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Launch::className(), 'targetAttribute' => ['launch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'launch_id' => 'Launch ID',
            'sequence' => 'Sequence',
            'path' => 'Path',
            'base_url' => 'Base Url',
            'type' => 'Type',
            'size' => 'Size',
            'name' => 'Name',
            'create_at' => 'Create At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLaunch()
    {
        return $this->hasOne(Launch::className(), ['id' => 'launch_id']);
    }
}
