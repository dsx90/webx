<?php

namespace common\modules\construction;

use common\modules\construction\controllers\admin\ConstructionController;
use common\modules\construction\models\Construction;
use Yii;

/**
 * construction module definition class
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = 'construction';

    /**
     * @inheritdoc
     */
    //public $controllerNamespace =  'common\modules\construction\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\construction\commands';
        }

        //yii construction/<command>/<sub_command>

        $this->params = [


        ];

        $this->layout = [
            'construction' => [
                'model'         => dirname(dirname(__DIR__)) . '\Construction',
                'controller'    => $this->controllerNamespace.'\ConstructionController',
                'form'          => '@common/modules/construction/views/admin/construction/_cform'
            ]
        ];

        // custom initialization code goes here
    }

    /*$this->insert('{{%content_type}}', [
        'title'         => 'Construction',
        'name'          => 'Выполнение работ',
        'icon'          => 'fa fa-wrench',
        'status'        => '1',
    ]);*/
}
