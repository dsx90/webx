<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m160101_000008_user_agent_address
 */
class m160101_000008_user_agent_address extends Migration
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

        //Таблица устройств с которых переходит пользователь
        $this->createTable('{{%user_agent}}', [
            'id'               => $this->primaryKey(),
            'agent'            => $this->string(20)->notNull()
        ], $tableOptions);

        //Таблица ip адресов
        $this->createTable('{{%user_ip}}', [
            'id'               => $this->primaryKey(),
            'user_id'          => $this->integer(),
            'agent_id'         => $this->integer()
        ], $tableOptions);

        if ($this->db->driverName === 'pgsql') {
            $this->addColumn('{{%user_ip}}', 'IP', 'CIDR');
        } else {
            $this->addColumn('{{%user_ip}}', 'IP', 'VARCHAR(20)');
        }

        $this->createIndex('index_user_id', '{{%user_ip}}', '[[user_id]]');

        $this->createIndex('m_index_user_id_agent_id_ip', '{{%user_ip}}', 'user_id, agent_id, IP', true);

        $this->addForeignKey(
            'fk_user_ip_user',
            '{{%user_ip}}',
            'user_id',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk_user_ip_user_agent',
            '{{%user_ip}}',
            'agent_id',
            '{{%user_agent}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->insert('{{%panel_item}}', [
            'parent_id' => PanelItem::findOne(['key' => 'statistic'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Активность пользователей',
            'key'       => 'user_active',
            'options'   => null,
            'url'       => '/user_active',
            'icon'      => 'fa fa-star-o',
            'visible'   => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_ip_user_agent', '{{%user_ip}}');
        $this->dropForeignKey('fk_user_ip_user', '{{%user_ip}}');

        $this->dropTable('{{%user_agent}}');
        $this->dropTable('{{%user_ip}}');
        $this->delete('{{%panel_item}}', ['key' => 'user_active']);
    }
}
