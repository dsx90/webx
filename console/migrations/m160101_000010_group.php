<?php

use yii\db\Migration;

/**
 * Class m190410_192741_group
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
            'title'             => $this->string()->notNull(),
        ] , $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190410_192741_group cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190410_192741_group cannot be reverted.\n";

        return false;
    }
    */
}
