<?php

namespace common\modules\tehnic;

use common\modules\tehnic\controllers\admin\TehnicCatController;
use common\modules\tehnic\controllers\admin\TehnicController;
use common\modules\tehnic\models\Tehnic;
use common\modules\tehnic\models\TehnicCat;
use Yii;
use yii\console\Application;

/**
 * tehnic module definition class
 */
class Module extends \yii\base\Module
{
    public static function controllerNamespace()
    {
        if (Yii::$app instanceof Application) {
            return 'app\modules\tehnic\commands';
        }
        return 'common\modules\tehnic\controllers';
    }

    public static function layout()
    {
        return [
            'tehnic' => [
                'name'          => Yii::t('common', 'Tehnic'),
                'model'         => Tehnic::class,
                'controller'    => TehnicController::class,
                'form'          => '@common/modules/tehnic/views/admin/tehnic/_cform'
            ],
            'tehnic-cat' => [
                'name'          => Yii::t('common', 'Technic Categories'),
                'model'         => TehnicCat::class,
                'controller'    => TehnicCatController::class,
                'form'          => '@common/modules/tehnic/views/admin/tehnic-cat/_cform'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
