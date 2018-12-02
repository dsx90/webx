<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:39
 */

namespace backend\components;

use backend\models\Module;

abstract class VersionModule extends Module
{
    /**
     * Возвращает список правил роутинга.
     *
     * @return array
     */
    public static function getUrlRules()
    {
        return [];
    }

    /**
     * Возвращает список обработчиков событий.
     *
     * @return array [
     *   eventName => [
     *     handler 1,
     *     handler 2,
     *     ...
     *   ]
     * ]
     */
    public static function getEventHandlers()
    {
        return [];
    }
    // ...
}