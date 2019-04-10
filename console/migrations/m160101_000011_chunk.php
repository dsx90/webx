<?php

use yii\db\Migration;

/**
 * Class m190410_191619_chunk
 */
class m160101_000011_chunk extends Migration
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

        //Таблица чанков (Фрагментов HTML кода)
        $this->createTable('{{%chunk}}',[
            'id'                => $this->primaryKey(),
            'group_id'          => $this->integer(),
            'name'              => $this->string(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'code'              => $this->text(),
            'is_file'           => $this->boolean(),
            'file'              => $this->string()
        ], $tableOptions);

        // Связь чанков с грппой
        $this->addForeignKey(
            'fk_group_chunk',
            '{{%chunk}}',
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
        $this->dropForeignKey('fk_group_chunk', '{{%chunk}}');
        $this->dropTable('{{%chunk}}');
    }
}
