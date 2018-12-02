<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:16
 */

namespace backend\models;

use backend\models\queries\ModuleQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id Id модуля. Это не AI поле, а id модуля в приложении. Соответствует его неймспейсу
 * @property string $name Человекопонятное название (для админки)
 * @property bool $is_active Если модуль выключен, он не подключается
 * @property int $version_id Id активной версии.
 * @property string $source Полное имя класса модуля
 * @property ModuleVersion[] $versions Список всех версий этого модуля (для админки)
 * @property ModuleVersion|null $activeVersion Активная версия
 */
class Module extends ActiveRecord
{
    private static $activeVersionIds = [];
    /** @return ModuleQuery */
    public static function find()
    {
        return new ModuleQuery(static::class);
    }
    /**
     * Return id of active version for module.
     * @param string $moduleId
     * @return string|null
     */
    public static function getActiveVersionIdByModuleId($moduleId)
    {
        if (!isset(static::$activeVersionIds[$moduleId])) {
            $id = static::find()
                ->select('version_id')
                ->andWhere(['id' => $moduleId])
                ->active()
                ->scalar();
            static::$activeVersionIds[$moduleId] = $id ?: null;
        }
        return static::$activeVersionIds[$moduleId];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(ModuleVersion::class, ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveVersion()
    {
        return $this->hasOne(ModuleVersion::class, [
            'id' => 'version_id',
            'module_id' => 'id',
        ]);
    }
}
