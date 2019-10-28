<?php


namespace common\components;


use common\models\Launch;
use yii\db\ActiveRecord;

/**
 * Class LaunchActiveRecord
 * @package common\components
 *
 * @property int $launch_id
 *
 * @property Launch $launch
 */

class LaunchActiveRecord extends ActiveRecord
{
    public $launch_id;

    public function getLaunch()
    {
        return $this->hasOne(Launch::class, ['id' => 'launch_id']);
    }
}