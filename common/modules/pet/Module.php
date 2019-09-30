<?php

namespace common\modules\pet;

use Yii;
use yii\console\Application;

/**
 * pet module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    //public $controllerNamespace = 'common\modules\pet\controllers';

    public $defaultRoute = 'admin';

    public static function controllerNamespace()
    {
        if (Yii::$app instanceof Application) {
            return 'app\modules\pet\commands';
        }
        return 'common\modules\pet\controllers';
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
