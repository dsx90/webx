<?php

use common\models\Panel;
use common\models\PanelItem;
use console\components\Migration;

/**
 * Class m190724_124803_attribute
 */
class m190724_124803_attribute extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attribute}}', [
            'id'                    => $this->primaryKey(),
            'name'                  => $this->string(50)->notNull(),
            'description'           => $this->string(),
            'scale'                 => $this->string(3)->notNull(),
            'required'              => $this->boolean(),
            'type'                  => $this->smallInteger(), //Тип поля для валидации
            'max'                   => $this->smallInteger(),
            'sort'                  => $this->smallInteger()
        ], $this->tableOptions());

        $this->createTable('{{%attribute_value}}', [
            'id'                    => $this->primaryKey(),
            'attribute_id'          => $this->integer(),
            'value'                 => $this->string()
        ], $this->tableOptions());

        $this->createTable('{{%attribute_value_launch}}', [
            'launch_id'             => $this->integer(),
            'attribute_id'          => $this->integer(),
            'value_id'              => $this->integer()
        ], $this->tableOptions());

        $this->createTable('{{%attribute_link_category}}', [
            'id'                    => $this->primaryKey(),
            'category_id'           => $this->integer()->notNull(),
            'attribute_id'          => $this->integer()->notNull(),
            'visible'               => $this->boolean(),
            'filter'                => $this->boolean(),
        ], $this->tableOptions());



        $this->createIndex('idx-attribute-name', '{{%attribute}}', '[[name]]');

        $this->addForeignKey('fk-attribute_value-attribute', '{{%attribute_value}}', '[[attribute_id]]', '{{%attribute}}', '[[id]]');
        $this->addForeignKey('fk-attribute_link_category-attribute', '{{%attribute_link_category}}', '[[attribute_id]]', '{{%attribute}}', '[[id]]');
        $this->addForeignKey('fk-attribute_link_category-category', '{{%attribute_link_category}}', '[[category_id]]', '{{%launch}}', '[[id]]');
        $this->addForeignKey('fk-attribute_value_launch-launch', '{{%attribute_value_launch}}', '[[launch_id]]', '{{%launch}}', '[[id]]');
        $this->addForeignKey('fk-attribute_value_launch-attribute', '{{%attribute_value_launch}}', '[[attribute_id]]', '{{%attribute}}', '[[id]]');
        $this->addForeignKey('fk-attribute_value_launch-value', '{{%attribute_value_launch}}', '[[value_id]]', '{{%attribute_value}}', '[[id]]');

        $this->insert('{{%panel_item}}', [
            'parent_id' => PanelItem::findOne(['key' => 'settings'])->id,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Атрибуты',
            'key'       => 'attribute',
            'options'   => null,
            'url'       => '/attribute',
            'icon'      => 'fa fa-product-hunt',
            'visible'   => null
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-attribute_value-attribute', '{{%attribute_value}}');
        $this->dropForeignKey('fk-attribute_link_category-attribute', '{{$attribute_link_category}}');
        $this->dropForeignKey('fk-attribute_link_category-category', '{{%attribute_link_category}}');
        $this->dropForeignKey('fk-attribute_value_launch-launch', '{{%attribute_value_launch}}');
        $this->dropForeignKey('fk-attribute_value_launch-attribute', '{{%attribute_value_launch}}');
        $this->dropForeignKey('fk-attribute_value_launch-value', '{{%attribute_value_launch}}');

        $this->dropTable('{{%attribute}}');
        $this->dropTable('{{%attribute_value}}');
        $this->dropTable('{{%attribute_link_category}}');
        $this->dropTable('{{%attribute_value}}');

        $this->delete('{{%panel_item}}', ['key' => 'attribute']);
    }
}
