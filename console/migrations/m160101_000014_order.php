<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;

class m160101_000014_order extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}',[
            'id'                    => $this->primaryKey(),
            'table'                 => $this->string()->notNull(),
            'link_id'               => $this->integer()->notNull(),
            'user_ip_id'            => $this->integer()->notNull(),
            'manager_id'            => $this->integer(),
            'comment_id'            => $this->integer(),
            'manager_comment_id'    => $this->integer(),
            'status'                => $this->smallInteger(),
            'created_at'            => $this->integer(),
            'update_at'             => $this->integer(),
        ], $tableOptions);

        /** Предложение */
        $this->createTable('{{%offer}}', [
            'id'            => $this->primaryKey(),
            'price'         => $this->money(),
            'create_at'     => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-order-table', '{{%order}}', '[[table]]');
        $this->createIndex('idx-order-status', '{{%order}}', '[[status]]');

        $this->addForeignKey(
            'fk-order-user_ip',
            '{{%order}}',
            'user_ip_id',
            '{{%user_ip}}',
            'id'
        );

        $this->addForeignKey(
            'fk-order-manager',
            '{{%order}}',
            'manager_id',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey(
            'fk-order-comment',
            '{{%order}}',
            'comment_id',
            '{{%comment}}',
            'id'
        );

        $this->addForeignKey(
            'fk-order-manger_comment',
            '{{%order}}',
            'manager_comment_id',
            '{{%comment}}',
            'id'
        );

        $this->insert('{{%panel_item}}', [
            'parent_id' => null,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Заказы',
            'key'       => 'order',
            'options'   => null,
            'url'       => '/order',
            'icon'      => 'fa fa-shopping-cart',
            'visible'   => null
        ]);

        $this->insert('{{%panel_item}}', [
            'parent_id' => null,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Предложения',
            'key'       => 'offer',
            'options'   => null,
            'url'       => '/offer',
            'icon'      => 'fa fa-shopping-cart',
            'visible'   => null
        ]);

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-order-manger_comment', '{{%order}}');
        $this->dropForeignKey('fk-order-comment', '{{%order}}');
        $this->dropForeignKey('fk-order-manager', '{{%order}}');
        $this->dropForeignKey('fk-order-user_ip', '{{%order}}');

        $this->dropTable('{{%order}}');
        $this->dropTable('{{%offer}}');

        $this->delete('{{%panel_item}}', ['key' => 'order']);
    }

}
