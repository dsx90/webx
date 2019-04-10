<?php

use yii\db\Migration;

/**
 * Class m180928_224647_layout_module
 */
class m180928_224647_layout_module extends Migration
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

        //Диспечер модулей
        $this->createTable('{{%layout_module}}', [
            'id'            => $this->primaryKey(),
            'layout_id'     => $this->integer()->notNull(),             // id страницы для вывода нашего модуля
            'module'        => $this->string(150)->notNull(),    // название модуля
            'status'        => $this->boolean()->defaultValue(true),
            'position'      => $this->string(30)->notNull(),
            'sort_order'    => $this->integer()->defaultValue(1),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%layout_module}}');
    }
}
