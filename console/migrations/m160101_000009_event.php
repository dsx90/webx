<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;

/**
 * Class m160101_000009_visit
 */
class m160101_000009_event extends Migration
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
        $this->createTable('{{%event}}', [
            'id'                => $this->primaryKey(),
            'created_at'        => $this->integer()->notNull(),
            'event'             => $this->string()->notNull(),
            'user_ip_id'        => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_event_user_ip',
            '{{%event}}',
            'user_ip_id',
            '{{%user_ip}}',
            'id'
        );

        $this->insert('{{%panel_item}}', [
            'parent_id' => PanelItem::findOne(['key' => 'statistic'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Event',
            'key'       => 'event',
            'options'   => null,
            'url'       => '/event',
            'icon'      => 'fa fa-bullseye',
            'visible'   => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_event_user_ip', '{{%event}}');

        $this->dropTable('{{%event}}');
        $this->delete('{{%panel_item}}', ['key' => 'event']);
    }
}
