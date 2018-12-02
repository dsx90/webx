<?php
/**
 * Created by PhpStorm.
 * User: Admin
* Date: 30.09.2018
* Time: 1:15
*/

namespace backend\components;

use backend\models\Module;
use yii\web\Application;

class WebApplication extends Application
{
    /** @inheritdoc */
    public function init()
    {
        parent::init();
        // ...
        $this->enableModules();
    }

    /**
     * Подключает активные версии модулей
     */
    protected function enableModules()
    {
        $modules = Module::find()->active()->with('activeVersion');
        foreach ($modules->each() as $module) {
            if (!$module->activeVersion) {
                continue;
            }
            $this->setModule($module->id, $module->activeVersion->source);          // Добавляем модуль в приложение
            $this->urlManager->registerModuleRules($module->activeVersion);         // Регистрируем правила роутинга
            $this->eventManager->registerModuleHandlers($module->activeVersion);    // Регистрируем обработчики событий
        }
    }
}