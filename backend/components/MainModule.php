<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:58
 */

namespace backend\components;

use backend\models\Module as ModuleAr;
use yii\base\Module;
use yii\helpers\Inflector;

abstract class MainModule extends Module
{
    /**
     * Возвращает объект класса $className из версии $version.
     *
     * @param string $className Имя класса, относительно корня модуля.
     * @param array $constructorArgs = [] Аргументы, передаваемые в конструктор.
     * @param string $moduleVersion = null Версия, в которой будет осуществляться поиск класса. Если NULL - будет использована активная версия.
     * @return mixed|null Объект класса или NULL, если класс не доступен.
     * @throws \yii\base\Exception
     */
    public static function getObject($className, array $constructorArgs = [], $moduleVersion = null)
    {
        $class = static::createFullClassName($className, $moduleVersion);
        return $class && class_exists($class) ? new $class(...$constructorArgs) : null;
    }
    /**
     * Возвращает полное имя класса $className из версии $version.
     *
     * @param string $className Имя класса, относительно корня модуля.
     * @param string $moduleVersion = null Версия, в которой будет осуществляться поиск класса. Если NULL - будет использована активная версия.
     * @return mixed|null Имя класса или NULL, если класс не доступен.
     * @throws \yii\base\Exception
     */
    public static function getClass($className, $moduleVersion = null)
    {
        $class = static::createFullClassName($className, $moduleVersion);
        return $class && class_exists($class) ? $class : null;
    }
    /**
     * Формирует полное имя класса из его относительного имени и версии модуля.
     *
     * @param string $name Имя класса, относительно корня модуля.
     * @param string $moduleVersion = null Id of module's version. Версия модуля. Если NULL - будет использована активная версия.
     * @return string|null Full name of class. Имя класса или NULL, если у модуля нет активной версии.
     */
    private static function createFullClassName($name, $moduleVersion = null)
    {
        $moduleClass = static::class;
        $moduleId = Inflector::underscore(substr($moduleClass, strrpos($moduleClass, '\\') + 1));
        if ($moduleVersion === null) {
            $moduleVersion = ModuleAr::getActiveVersionIdByModuleId($moduleId);
        }
        if ($moduleVersion === null) {
            return null;
        }
        $namespace = substr($moduleClass, 0, strrpos($moduleClass, '\\'));
        $className = ltrim($name, "\\");
        return "\\{$namespace}\\modules\\{$moduleVersion}\\{$className}";
    }

    public static function t($category, $message, $params = [], $language = null, $version = null)
    {
        $class = static::class;
        $id = Inflector::underscore(substr($class, strrpos($class, '\\') + 1));
        if ($version === null) {
            $version = ModuleAr::getActiveVersionIdByModuleId($id);
        }
        if ($version === null) {
            throw new Exception("Invalid module id: {$id}");
        }
        $category = "{$id}.{$version}.{$category}";
        return \Yii::t($category, $message, $params, $language);
    }
    // ...
}