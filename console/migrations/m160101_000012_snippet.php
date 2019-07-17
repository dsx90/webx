<?php

use common\models\Panel;
use common\models\PanelItem;
use yii\db\Migration;

/**
 * Class m190410_191631_snippet
 */
class m160101_000012_snippet extends Migration
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

        //Таблица сниппетов (Фрагментов PHP кода)
        $this->createTable('{{%snippet}}',[
            'id'                => $this->primaryKey(),
            'group_id'          => $this->integer(),
            'name'              => $this->string(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'code'              => $this->text(),
            'is_file'           => $this->boolean(),
            'file'              => $this->string()
        ], $tableOptions);

        // Связь сниппетов с группой
        $this->addForeignKey(
            'fk_group_snippet',
            '{{%snippet}}',
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
            'title'     => 'Snippet',
            'key'       => 'snippet',
            'options'   => null,
            'url'       => '/snippet',
            'icon'      => 'fa fa-code',
            'visible'   => 'administrator'
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_group_snippet', '{{%snippet}}');
        $this->dropTable('{{%snippet}}');
        $this->delete('{{%panel_item}}', ['key' => 'snippet']);
    }
}
