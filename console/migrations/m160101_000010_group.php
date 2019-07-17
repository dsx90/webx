<?php

use yii\db\Migration;

/**
 * Class m160101_000010_group
 */
class m160101_000010_group extends Migration
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

        //Таблица Категории
        $this->createTable('{{%group}}', [
            'id'                => $this->primaryKey(),
            'parent_id'         => $this->integer(),
            'title'             => $this->string()->notNull(),
        ] , $tableOptions);

        $this->addForeignKey(
            'fk_group_parent_group',
            '{{%group}}',
            'parent_id',
            '{{%group}}',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%group}}');
    }
}
