<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;

/**
 * Class m160101_000009_like
 */
class m160101_000009_like extends Migration
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

        //Таблица избранных документов
        $this->createTable('{{%like}}', [
            'id'                => $this->primaryKey(),
            'created_at'        => $this->integer()->notNull(),
            'table'             => $this->string()->notNull(),
            'link_id'           => $this->integer()->notNull(),
            'user_ip_id'        => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_like_user_ip',
            '{{%like}}',
            'user_ip_id',
            '{{%user_ip}}',
            'id'
        );

        $this->insert('{{%panel_item}}', [
            'parent_id' => PanelItem::findOne(['key' => 'statistic'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Избранные товары',
            'key'       => 'like',
            'options'   => null,
            'url'       => '/like',
            'icon'      => 'fa fa-star-o',
            'visible'   => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_fk_like_user_ip', '{{%like}}');

        $this->dropTable('{{%like}}');
        $this->delete('{{%panel_item}}', ['key' => 'like']);
    }
}
