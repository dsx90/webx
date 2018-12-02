<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:43
 */

namespace backend\models;

use backend\models\queries\ModuleVersionQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id Id подмодуля. Это не AI поле, а id модуля в приложении. Соответствует его неймспейсу внутри корневого модуля
 * @property string $name Человекопонятное название (для админки)
 * @property string $source Полное имя класса модуля
 * @property int $module_id Id родительского модуля
 */
class ModuleVersion extends ActiveRecord
{
    /** @inheritdoc */
    public static function find()
    {
        return new ModuleVersionQuery(static::class);
    }
}