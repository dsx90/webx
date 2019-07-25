<?php

use common\models\Panel;
use common\models\PanelItem;
use console\components\Migration;

class m170924_211339_tehnic extends Migration
{
    public function safeUp()
    {
        //Таблица полей категории техники
        $this->createTable('{{%tehnic_cat}}', [
            'launch_id'             => $this->integer()->unique()->notNull(),
            'content'               => $this->text(),
            'thumbnail'             => $this->string(),
            'thumbnail_base_url'    => $this->string(),
            'thumbnail_path'        => $this->string(),
        ], $this->tableOptions);

        //Таблица полей техники
        $this->createTable('{{%tehnic}}', [
            'launch_id'             => $this->integer()->unique()->notNull(),
            'content'               => $this->text(),
            'price'                 => $this->money(),
            'status'                => $this->smallInteger(),
            'views'                 => $this->integer(),
        ], $this->tableOptions);


        $this->createTable('{{%tehnic_cat_assignment}}', [
            'id'                    => $this->primaryKey(),
            'category'              => $this->integer(),
            'subcategory'           => $this->integer(),
        ], $this->tableOptions);




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
        ], $this->tableOptions);

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
            'title'         => 'Tehnic',
            'name'          => 'Спецтехника',
            'icon'          => 'fa fa-car',
            'status'        => '1',
            'model'         => 'common\modules\tehnic\models\Tehnic',
            'controller'    => 'common\modules\tehnic\controllers\admin\TehnicController',
            'form'          => '@common/modules/tehnic/views/admin/tehnic/_cform',
        ]);

        $this->insert('{{%content_type}}', [
            'title'         => 'Tehnic Category',
            'name'          => 'Категория техники',
            'icon'          => 'fa fa-cogs',
            'status'        => '1',
            'model'         => 'common\modules\tehnic\models\TehnicCat',
            'controller'    => 'common\modules\tehnic\controllers\admin\TehnicCatController',
            'form'          => '@common/modules/tehnic/views/admin/tehnic-cat/_cform',
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
            'title' => 'Tehnic',
        ]);

        $this->delete('{{%content_type}}', [
            'title' => 'Tehnic Category',
        ]);
    }
}
