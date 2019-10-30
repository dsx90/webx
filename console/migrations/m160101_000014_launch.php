<?php

use common\models\Panel;
use yii\db\Migration;
use common\models\PanelItem;

class m160101_000014_launch extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%language}}', [
            'id'                => $this->primaryKey(),
            'key'               => $this->string(3)
        ]);

        $this->createTable('{{%meta}}', [
            'launch_id'         => $this->integer(),
            'key'               => $this->string(3),
            'lang_id'           => $this->integer(),
            'title'             => $this->string(70)            ->comment('Заголовок'),
            'long_title'        => $this->string(70)            ->comment('Краткое описание'),
            'description'       => $this->string(150)           ->comment('Описание'),
            'keywords'          => $this->string(255)           ->comment('Ключевые слова'),
            'menutitle'         => $this->string(20)            ->comment('Заголовок меню'),
            'slug'              => $this->string(80)->unique()  ->comment('URL адрес'),
        ]);
        //Индекс алиасов
        $this->createIndex('idx-launch-slug', '{{%meta}}', 'slug');

        //Основная связующая таблица
        $this->createTable('{{%launch}}',[
            'id'                => $this->primaryKey(),
            'icon'              => $this->string(50),
            'status'            => $this->smallInteger()->notNull()    ->comment('Статус публикации'),
            'deleted'           => $this->boolean(),
            'hidemenu'          => $this->boolean(),
            'searchable'        => $this->boolean(),
            'richtext'          => $this->boolean(),
            'cacheable'         => $this->boolean(),
            'is_folder'         => $this->smallInteger(),
            'position'          => $this->integer(11),
            'content_type_id'   => $this->integer(11),
            'parent_id'         => $this->integer(11),
            'template_id'       => $this->integer(11),
            'child_template_id' => $this->integer(11),
            'author_id'         => $this->integer(11),
            'updater_id'        => $this->integer(11),
            'published_at'      => $this->integer(),
            'created_at'        => $this->integer(),
            'updated_at'        => $this->integer(),
            'unpub_date'        => $this->integer(),
        ], $tableOptions);

        //Таблица модулей
        $this->createTable('{{%content_type}}', [
            'id'                => $this->primaryKey(),
            'module'            => $this->string(),
            'key'               => $this->string(),
            'name'              => $this->string(),
            'icon'              => $this->string(20),
            'status'            => $this->boolean(),
            'params'            => $this->string()
        ], $tableOptions);

        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(80)
        ]);

        //Индексы родителей
        $this->createIndex('idx-launch-parent_id', '{{%launch}}', 'parent_id');
        //Индекс статуса публикации файла
        $this->createIndex('idx-launch-status', '{{%launch}}', 'status');

        // Связь мета с языком
        $this->addForeignKey(
            'fk_meta_language',
            '{{%meta}}',
            'lang_id',
            '{{%language}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Связь мета с языком
        $this->addForeignKey(
            'fk_launch_meta',
            '{{%meta}}',
            'launch_id',
            '{{%launch}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Связь документа с темами
        $this->addForeignKey(
            'fk_launch_template',
            '{{%launch}}',
            'template_id',
            '{{%template}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Связь документа с автором
        $this->addForeignKey(
            'fk_launch_author',
            '{{%launch}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Связь документа с редактором
        $this->addForeignKey(
            'fk_launch_updater',
            '{{%launch}}',
            'updater_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Связь документа с родителем
        $this->addForeignKey(
            'fk_launch_parent',
            '{{%launch}}',
            'parent_id',
            '{{%launch}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Связь документа с модулем
        $this->addForeignKey(
            'fk_launch_content_type',
            '{{%launch}}',
            'content_type_id',
            '{{%content_type}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->insert(PanelItem::tableName(), [
            'parent_id' => null,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Ресурсы',
            'key'       => 'launch',
            'options'   => null,
            'url'       => '/launch',
            'icon'      => 'fa fa-angle-double-right',
            'visible'   => null
        ]);

        $this->insert(PanelItem::tableName(), [
            'parent_id' => null,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Типы ресурсов',
            'key'       => 'content_type',
            'options'   => null,
            'url'       => '/content-type',
            'icon'      => 'fa fa-angle-double-right',
            'visible'   => 'administrator'
        ]);

        $this->insert(PanelItem::tableName(), [
            'parent_id' => null,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Города',
            'key'       => 'city',
            'options'   => null,
            'url'       => '/city',
            'icon'      => 'fa fa-map-signs',
            'visible'   => null
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_launch_content_type', '{{%launch}}');
        $this->dropForeignKey('fk_launch_parent', '{{%launch}}');
        $this->dropForeignKey('fk_launch_updater', '{{%launch}}');
        $this->dropForeignKey('fk_launch_author', '{{%launch}}');
        $this->dropForeignKey('fk_template_launch', '{{%launch}}');

        $this->dropTable('{{%launch}}');
        $this->dropTable('{{%content_type}}');
        $this->dropTable('{{%city}}');

        $this->delete(PanelItem::tableName(), ['key' => 'launch']);
        $this->delete(PanelItem::tableName(), ['key' => 'content_type']);
    }

}
