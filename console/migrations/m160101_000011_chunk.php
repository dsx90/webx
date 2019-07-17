<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;

/**
 * Class m160101_000011_chunk
 */
class m160101_000011_chunk extends Migration
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

        //Таблица чанков (Фрагментов HTML кода)
        $this->createTable('{{%chunk}}',[
            'id'                => $this->primaryKey(),
            'group_id'          => $this->integer(),
            'name'              => $this->string(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'code'              => $this->text(),
            'is_file'           => $this->boolean(),
            'file'              => $this->string()
        ], $tableOptions);

        // Связь чанков с грппой
        $this->addForeignKey(
            'fk_group_chunk',
            '{{%chunk}}',
            'group_id',
            '{{%group}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->insert('{{%panel_item}}', [
            'parent_id' => PanelItem::findOne(['key' => 'settings'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Chunk',
            'key'       => 'chunk',
            'options'   => null,
            'url'       => '/chunk',
            'icon'      => 'fa fa-comments',
            'visible'   => 'administrator'
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_group_chunk', '{{%chunk}}');
        $this->dropTable('{{%chunk}}');
        $this->delete('{{%panel_item}}', ['key' => 'chunk']);
    }
}
