<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:22
 */

namespace backend\components;

use backend\models\ModuleVersion;

class UrlManager extends \yii\web\UrlManager
{
    /**
     * Регистрирует роуты модуля.
     *
     * @param ModuleVersion $module
     */
    public function registerModuleRules($module)
    {
        $class = $module->source;
        $this->addRules($class::getUrlRules());
    }
    // ...
}