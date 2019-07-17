<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;

/**
 * Class m160101_000009_comment
 */
class m160101_000009_comment extends Migration
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

        //Таблица коментриев
        $this->createTable('{{%comment}}', [
            'id'                => $this->primaryKey(),
            'parent_id'         => $this->integer(),
            'table'             => $this->string()->notNull(),
            'link_id'           => $this->integer()->notNull(),
            'user_ip_id'        => $this->integer()->notNull(),
            'text'              => $this->string(),
            'created_at'        => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_comment_user_ip',
            '{{%comment}}',
            'user_ip_id',
            '{{%user_ip}}',
            'id'
        );

        $this->addForeignKey(
            'fk_comment_parent_comment',
            '{{%comment}}',
            'parent_id',
            '{{%comment}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->insert('{{%panel_item}}', [
            'parent_id' => PanelItem::findOne(['key' => 'statistic'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Коментарии',
            'key'       => 'comment',
            'options'   => null,
            'url'       => '/comment',
            'icon'      => 'fa fa-comments',
            'visible'   => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comment_parent_comment', '{{%comment}}');
        $this->dropForeignKey('fk_fk_comment_user_ip', '{{%comment}}');

        $this->dropTable('{{%comment}}');
        $this->delete('{{%panel_item}}', ['key' => 'comment']);
    }
}
