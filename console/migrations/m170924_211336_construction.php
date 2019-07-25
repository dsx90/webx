<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;
use common\models\ContentType;

class m170924_211336_construction extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%construction}}', [
            'launch_id' => $this->integer()->unique()->notNull(),
            'content' => $this->text(),
            'price' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey(
          'fk-construction-launch_id',
          '{{%construction}}',
          'launch_id',
          '{{%launch}}',
          'id',
          'CASCADE',
          'RESTRICT'
        );

        $this->insert(ContentType::tableName(), [
            'module'        => 'construction',
            'key'           => 'construction',
            'name'          => 'Выполнение работ',
            'icon'          => 'fa fa-wrench',
            'status'        => '1'
        ]);

        $this->insert(PanelItem::tableName(), [
            'parent_id' => PanelItem::findOne(['key' => 'modules'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Выполнение работ',
            'key'       => 'construction',
            'options'   => null,
            'url'       => '/construction',
            'icon'      => 'fa fa-product-hunt',
            'visible'   => null
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%construction}}');

        $this->delete('{{%content_type}}', ['title' => 'Construction',]);
        $this->delete(PanelItem::tableName(), ['key' => 'construction']);
    }
}
