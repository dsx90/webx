<?php

use console\components\Migration;

class m170924_211339_tehnic extends Migration
{
    public function safeUp()
    {
        //Таблица полей категории техники
        $this->createTable('{{%tehnic_cat}}', [
            'launch_id'             => $this->integer()->unique()->notNull(),
            'content'               => $this->text()
        ], $this->tableOptions());

        //Таблица полей техники
        $this->createTable('{{%tehnic}}', [
            'launch_id'             => $this->integer()->unique()->notNull(),
            'content'               => $this->text(),
            'price'                 => $this->money(),
            'status'                => $this->smallInteger(),
            'views'                 => $this->integer(),
        ], $this->tableOptions());


        $this->createTable('{{%tehnic_cat_assignment}}', [
            'id'                    => $this->primaryKey(),
            'category'              => $this->integer(),
            'subcategory'           => $this->integer(),
        ], $this->tableOptions());

        //Таблица заказов техники
        $this->createTable('{{%tehnic_customer}}', [
            'id'                    => $this->primaryKey(),
            'customer_id'           => $this->integer(),
            'order_id'              => $this->integer(),
            'address'               => $this->string(),
            'work_time'             => $this->integer(),
            'order_time'            => $this->integer(),
            'order_on_time'         => $this->integer(),
            'value_work'            => $this->integer(),
            'percent'               => $this->integer(),
        ], $this->tableOptions());

        //New Foreign Key Index
        $this->addForeignKey(
            'fk-tehnic_cat-launch',
            '{{%tehnic_cat}}',
            'launch_id',
            '{{%launch}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-tehnic-launch',
            '{{%tehnic}}',
            'launch_id',
            '{{%launch}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-tehnic_order',
            '{{%tehnic_customer}}',
            'customer_id',
            '{{%order}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tehnic_customer-tehnic',
            '{{%tehnic_customer}}',
            'order_id',
            '{{%tehnic}}',
            'launch_id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->insert('{{%content_type}}', [
            'module'        => 'tehnic',
            'key'           => 'tehnic',
            'name'          => 'Спецтехника',
            'icon'          => 'fa fa-car',
            'status'        => '1'
        ]);

        $this->insert('{{%content_type}}', [
            'module'        => 'tehnic',
            'key'           => 'tehnic_category',
            'name'          => 'Категория техники',
            'icon'          => 'fa fa-cogs',
            'status'        => '1',
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-tehnic_customer-tehnic', '{{%tehnic_customer}}');
        $this->dropForeignKey('fk-tehnic_customer-customer','{{%tehnic_customer}}');
        $this->dropForeignKey('fk-tehnic_option_value-tehnic_option','{{%tehnic_option_value}}');
        $this->dropForeignKey('fk-tehnic_option_value-tehnic','{{%tehnic_option_value}}');
        $this->dropForeignKey('fk-tehnic_option_assignment-tehnic_option','{{%tehnic_option_assignment}}');
        $this->dropForeignKey('fk-tehnic_option_assignment-launch','{{%tehnic_option_assignment}}');
        $this->dropForeignKey('fk-tehnic-launch','{{%tehnic}}');
        $this->dropForeignKey('fk-tehnic_cat-launch','{{%tehnic_cat}}');


        $this->dropTable('{{%tehnic_cat}}');
        $this->dropTable('{{%tehnic}}');
        $this->dropTable('{{%tehnic_customer}}');

        $this->delete('{{%content_type}}', [
            'key' => ['tehnic', 'tehnic_category'],
        ]);
    }
}
