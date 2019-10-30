<?php

namespace common\modules\pet;

use common\modules\pet\controllers\admin\PetController;
use common\modules\pet\controllers\admin\TiesPetsController;
use common\modules\pet\models\Breed;
use common\modules\pet\models\Pet;
use common\modules\pet\models\TiesPets;
use common\modules\tehnic\controllers\admin\TehnicCatController;
use common\modules\tehnic\controllers\admin\TehnicController;
use common\modules\tehnic\models\Tehnic;
use common\modules\tehnic\models\TehnicCat;
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

    public static function layout()
    {
        return [
            'pet' => [
                'name'          => Yii::t('common', 'Pet'),
                'model'         => Pet::class,
                'controller'    => PetController::class,
                'form'          => '@common/modules/pet/views/admin/pet/_cform',
                'hideChildTable'=> true,
                'finish'        => true,
            ],
            'breed' => [
                'name'          => Yii::t('common', 'Breed'),
                'model'         => Breed::class,
                'controller'    => '',
                'form'          => '@common/modules/pet/views/admin/breed/_cform',
                'child'         => 'pet'
            ]
        ];
    }

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
