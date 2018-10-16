<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:47
 */

namespace backend\components;

use backend\models\ModuleVersion;
use yii\base\Event;

class EventManager
{
    /**
     * Бросает событие
     *
     * @param string $name Event name
     * @param Event $event = null
     */
    public function fire($name, $event = null)
    {
        \Yii::$app->trigger($name, $event);
    }

    /**
     * Регистрирует обработчики
     * @param array $handlers
     */
    public function registerHandlers($handlers)
    {
        foreach ($handlers as $event => $callbacks) {
            if (!is_array($callbacks)) {
                $callbacks = [$callbacks];
            }
            foreach ($callbacks as $callback) {
                \Yii::$app->on($event, $callback);
            }
        }
    }

    /**
     * Регистрирует обработчики модуля.
     *
     * @param ModuleVersion $module
     */
    public function registerModuleHandlers($module)
    {
        $class = $module->source;
        $handlers = $class::getEventHandlers();
        $this->registerHandlers($handlers);
    }
    // ...
}