<?php

namespace common\modules\shop;

use common\modules\shop\controllers\admin\ProductController;
use common\modules\shop\models\Product;
use Yii;
use yii\console\Application;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = 'shop';

    public static function controllerNamespace()
    {
        if (Yii::$app instanceof Application) {
            return 'app\modules\shop\commands';
        }
        return 'common\modules\shop\controllers';
    }

    public static function layout()
    {
        return [
            'product' => [
                'name'          => Yii::t('common', 'Product'),
                'model'         => Product::class,
                'controller'    => ProductController::class,
                'form'          => '@common/modules/shop/views/admin/product/_cform'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->controllerNamespace = $this->controllerNamespace();
        $this->layout = $this->layout();
    }
}
