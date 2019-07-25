<?php
namespace console\components;

/**
 * Class Migration
 *
 * @property-read string $tableOptions
 * @package console\components
 */
class Migration extends \yii\db\Migration
{
    protected function tableOptions(){
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        return $tableOptions;
    }

}