<?php

use yii\db\Migration;

/**
 * Class m190410_191645_template
 */
class m160101_000013_template extends Migration
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

        //Таблица шаблонов template
        $this->createTable('{{%template}}', [
            'id'                => $this->primaryKey(),
            'group_id'          => $this->integer(),
            'title'             => $this->string()->unique()->notNull(),
            'key'               => $this->string()->unique()->notNull(),
            'description'       => $this->text(),
            'path'              => $this->string(),
            'display'           => $this->smallInteger()->defaultValue('0'),
        ] , $tableOptions);

        //Индексы и ключи таблицы шаблонов template
        $this->createIndex('idx-template-title', '{{%template}}', 'key');

        // Связь документа с темами
        $this->addForeignKey(
            'fk_group_template',
            '{{%template}}',
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
        $this->dropForeignKey('fk_template_group', '{{%group}}');
        $this->dropTable('{{%template}}');
    }
}
