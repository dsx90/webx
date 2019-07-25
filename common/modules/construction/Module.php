<?php

namespace common\modules\construction;

use yii\console\Application;
use Yii;

/**
 * construction module definition class
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = 'construction';

    public static function controllerNamespace()
    {
        if (Yii::$app instanceof Application) {
            return 'app\modules\construction\commands';
        }
        return 'common\modules\construction\controllers';
    }

    public static function layout()
    {
        return [
            'construction' => [
                'model'         => dirname(dirname(__DIR__)) . '\Construction',
                'controller'    => self::controllerNamespace().'\ConstructionController',
                'form'          => '@common/modules/construction/views/admin/construction/_cform'
            ]
        ];
    }

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

        $this->controllerNamespace = $this->controllerNamespace();
        $this->layout = $this->layout();
        //yii construction/<command>/<sub_command>

//        $this->params = [
//
//
//        ];
        // custom initialization code goes here
    }

    /*$this->insert('{{%content_type}}', [
        'title'         => 'Construction',
        'name'          => 'Выполнение работ',
        'icon'          => 'fa fa-wrench',
        'status'        => '1',
    ]);*/
}
