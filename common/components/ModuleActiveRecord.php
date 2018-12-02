<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 2:25
 */

namespace common\components;

use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

abstract class ModuleActiveRecord extends ActiveRecord
{
    /** @inheritdoc */
    public static function tableName()
    {
        $className = static::class;
        return
            static::getTablePrefix($className) .
            Inflector::camel2id(StringHelper::basename($className), '_');
    }

    /**
     * Формирует префикс для имени таблицы.
     *
     * @param string $className
     * @return string
     */
    public static function getTablePrefix($className)
    {
        list(, $idModule, $tail) = explode('\\modules\\', $className);
        if (!$idModule) {
            return '';
        }
        $idVersion = explode('\\', $tail)[0];
        return $idModule . '_' . $idVersion . '_';
    }
}