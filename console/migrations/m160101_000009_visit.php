<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;

/**
 * Class m160101_000009_visit
 */
class m160101_000009_visit extends Migration
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

        //Таблица просмотров документов visit
        $this->createTable('{{%visit}}', [
            'id'                => $this->primaryKey(),
            'created_at'        => $this->integer()->notNull(),
            'table'             => $this->string()->notNull(),
            'link_id'           => $this->integer()->notNull(),
            'user_ip_id'        => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_visit_user_ip',
            '{{%visit}}',
            'user_ip_id',
            '{{%user_ip}}',
            'id'
        );

        $this->insert('{{%panel_item}}', [
            'parent_id' => PanelItem::findOne(['key' => 'statistic'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Visit',
            'key'       => 'visit',
            'options'   => null,
            'url'       => '/visit',
            'icon'      => 'fa fa-eye',
            'visible'   => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_visit_user_ip', '{{%visit}}');

        $this->dropTable('{{%visit}}');
        $this->delete('{{%panel_item}}', ['key' => 'visit']);
    }
}
