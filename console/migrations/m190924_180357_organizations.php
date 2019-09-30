<?php

use yii\db\Migration;

/**
 * Class m190924_180357_organizations
 */
class m190924_180357_organizations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%organization}}', [
            'id'        => $this->primaryKey(),
            'name'      => $this->string('80'),
            'city_id'   => $this->integer(),
        ],$tableOptions);

        $this->addForeignKey('fk-organization-city', '{{%organization}}', '[[city_id]]', 'city', '[[id]]');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-organization-city', '{{%organization}}');

        $this->dropTable('{{%organizations}}');
    }
}
