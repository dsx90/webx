<?php

use yii\db\Migration;

/**
 * Class m190410_191631_snippet
 */
class m160101_000012_snippet extends Migration
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

        //Таблица сниппетов (Фрагментов PHP кода)
        $this->createTable('{{%snippet}}',[
            'id'                => $this->primaryKey(),
            'group_id'          => $this->integer(),
            'name'              => $this->string(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'code'              => $this->text(),
            'is_file'           => $this->boolean(),
            'file'              => $this->string()
        ], $tableOptions);

        // Связь сниппетов с группой
        $this->addForeignKey(
            'fk_group_snippet',
            '{{%snippet}}',
            'group_id',
            '{{%group}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_group_snippet', '{{%snippet}}');
        $this->dropTable('{{%snippet}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190410_191631_snippet cannot be reverted.\n";

        return false;
    }
    */
}
