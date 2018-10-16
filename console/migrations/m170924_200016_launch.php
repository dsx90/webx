<?php

use yii\db\Migration;

class m170924_200016_launch extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //Основная связующая таблица
        $this->createTable('{{%launch}}',[
            'id'                => $this->primaryKey(),
            'title'             => $this->string(70),
            'long_title'        => $this->string(70),
            'description'       => $this->string(150),
            'keywords'          => $this->string(255),
            'menutitle'         => $this->string(20),
            'slug'              => $this->string(80)->unique(),
            'status'            => $this->smallInteger()->notNull(),
            'deleted'           => $this->boolean(),
            'hidemenu'          => $this->boolean(),
            'link_attributes'   => $this->string(255),
            'searchable'        => $this->boolean(),
            'richtext'          => $this->boolean(),
            'cacheable'         => $this->boolean(),
            'is_folder'         => $this->smallInteger(),
            'position'          => $this->integer(11),
            'content_type_id'   => $this->integer(11),
            'parent_id'         => $this->integer(11),
            'template_id'       => $this->integer(11),
            'author_id'         => $this->integer(11),
            'updater_id'        => $this->integer(11),
            'published_at'      => $this->integer(),
            'created_at'        => $this->integer(),
            'updated_at'        => $this->integer(),
            'unpub_date'        => $this->integer(),
        ], $tableOptions);
        //Таблица доменов
        $this->createTable('{{%context}}',[
            'id'                => $this->primaryKey(),
            'title'             => $this->string(50)->unique(),
            'key'               => $this->string(),
            'description'       => $this->string(255),
            'sort'              => $this->smallInteger(),
            'slug'              => $this->string(50)->unique()
        ], $tableOptions);
        // Таблица [ключей => значений] для домена
        // Номера телефонов, График рабочего времени, Местоположение, Адрес, Настройки и т.д
        $this->createTable('{{%context_key}}',[
            'id'                => $this->primaryKey(),
            'context_id'        => $this->integer(11),
            'namespace'         => $this->string(50),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'key'               => $this->string(50),
            'value'             => $this->text(),
        ], $tableOptions);
        //Таблица модулей
        $this->createTable('{{%content_type}}', [
            'id'                => $this->primaryKey(),
            'title'             => $this->string(),
            'name'              => $this->string(),
            'icon'              => $this->string(20),
            'status'            => $this->boolean(),
            'model'             => $this->string(),
            'controller'        => $this->string(),
            'form'              => $this->string(),
        ], $tableOptions);
        //Таблица Категории
        $this->createTable('{{%group}}', [
            'id'                => $this->primaryKey(),
            'title'             => $this->string()->notNull(),
        ] , $tableOptions);
        //Таблица шаблонов template
        $this->createTable('{{%template}}', [
            'id'                => $this->primaryKey(),
            'category_id'       => $this->integer(),
            'title'             => $this->string()->notNull(),
            'description'       => $this->text(),
            'path'              => $this->string(),
            'display'           => $this->smallInteger()->defaultValue('0'),
        ] , $tableOptions);
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
        //Таблица просмотров документов visit
        $this->createTable('{{%visit}}', [
            'id'                => $this->primaryKey(),
            'created_at'        => $this->integer()->notNull(),
            'launch_id'         => $this->integer()->notNull(),
            'ip'                => $this->string(20)->notNull(),
            'user_agent'        => $this->text(),
            'user_id'           => $this->integer(),
        ], $tableOptions);
        //Таблица просмотров документов visit
        $this->createTable('{{%like}}', [
            'id'                => $this->primaryKey(),
            'created_at'        => $this->integer()->notNull(),
            'launch_id'         => $this->integer()->notNull(),
            'ip'                => $this->string(20)->notNull(),
            'user_agent'        => $this->text(),
            'user_id'           => $this->integer(),
        ], $tableOptions);
        //Таблица панелей
        $this->createTable('{{%panel}}',[
            'id'                => $this->primaryKey(),
            'context_id'        => $this->integer(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'key'               => $this->string(50)->unique(),
            'status'            => $this->smallInteger()->defaultValue(true),
            'sort'              => $this->smallInteger(),
        ], $tableOptions);
        // Содержимое панелей
        $this->createTable('{{%panel_item}}',[
            'id'                => $this->primaryKey(),
            'parent_id'         => $this->integer(),
            'panel_id'          => $this->integer(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'key'               => $this->string(50)->unique(),
            'slug'              => $this->string(50)->unique(),
            'sort'              => $this->smallInteger()->unique(),
            'status'            => $this->smallInteger()->defaultValue(true),
            'richtext'          => $this->text()
        ], $tableOptions);
        //Индексы и ключи таблицы шаблонов template
        $this->createIndex(
            'idx-template-title',
            '{{%template}}',
            'title'
        );
        //Индексы родителей
        $this->createIndex(
            'idx-launch-parent_id',
            '{{%launch}}',
            'parent_id'
        );
        //Индекс статуса публикации файла
        $this->createIndex(
            'idx-launch-status',
            '{{%launch}}',
            'status'
        );
        //Индекс алиасов
        $this->createIndex(
            'idx-launch-slug',
            '{{%launch}}',
            'slug'
        );
        //Индексы и ключи таблицы таблицы просмотров документов visit
        $this->addForeignKey(
            'fk_launch_visit',
            '{{%visit}}',
            'launch_id',
            '{{%launch}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        //Индексы и ключи таблицы таблицы просмотров документов like
        $this->addForeignKey(
            'fk_launch_like',
            '{{%like}}',
            'launch_id',
            '{{%launch}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        // Связь ключей с доменом
//        $this->addForeignKey(
//            'fk_context_context_key',
//            '{{%context_key}}',
//            'context_id',
//            '{{%context}}',
//            'id',
//            'CASCADE',
//            'CASCADE'
//        );
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
        // Связь содержимого с панелью
        $this->addForeignKey(
            'fk_panel_panel_item',
            '{{%panel_item}}',
            'panel_id',
            '{{%panel}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        // Вложенные категории значений панели
        $this->addForeignKey(
            'fk_panel_item_id_parent_id',
            '{{%panel_item}}',
            'parent_id',
            '{{%panel_item}}',
            'id',
            'RESTRICT',
            'RESTRICT'
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

        $this->insert('{{%context}}', [
            'id'                => 1,
            'title'             => 'Admin Panel',
            'key'               => 'admin',
            'slug'              => 'be'
        ]);

        $this->insert('{{%context}}', [
            'id'                => 2,
            'title'             => 'Site',   // Название города,
            'key'               => 'site',      // city, module,
            'slug'              => '/'
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 2,
            'title'             => 'Регистрация через фронтенд',
            'namespace'         => 'frontend',
            'description'       => 'Регистрация через фронтенд',
            'key'               => 'frontend.registration',
            'value'             => 1,
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 2,
            'title'             => 'Подтверждение по электронной почте',
            'namespace'         => 'frontend',
            'description'       => 'Подтверждение по электронной почте',
            'key'               => 'frontend.email-confirm',
            'value'             => 1,
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 2,
            'title'             => 'Номер телефона',
            'namespace'         => 'frontend',
            'description'       => 'Номер телефона',
            'key'               => 'site.phone',
            'value'             => '89998887766',
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 1,
            'title'             => 'Тема админ панели',
            'namespace'         => 'backend',
            'description'       => 'Тема админ панели',
            'key'               => 'backend.theme-skin',
            'value'             => 'skin-blue',
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 1,
            'title'             => 'Фиксированное меню',
            'namespace'         => 'backend',
            'description'       => 'Фиксированное меню',
            'key'               => 'backend.layout-fixed',
            'value'             => 0,
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 1,
            'title'             => 'Контейнер меню',
            'namespace'         => 'backend',
            'description'       => 'Контейнер меню',
            'key'               => 'backend.layout-boxed',
            'value'             => 0,
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 1,
            'title'             => 'Сжатое меню',
            'namespace'         => 'backend',
            'description'       => 'Сжатое меню',
            'key'               => 'backend.layout-collapsed-sidebar',
            'value'             => 0,
        ]);

        $this->insert('{{%context_key}}',[
            'context_id'        => 1,
            'title'             => 'Маленькое меню',
            'namespace'         => 'backend',
            'description'       => 'Маленькое меню',
            'key'               => 'backend.layout-mini-sidebar',
            'value'             => 0,
        ]);
        // Dashboard
        $this->insert('{{%panel}}', [
            'id'                => 1,
            'context_id'        => 0,
            'title'             => 'dashboard',
            'key'               => 'dashboard'
        ]);
        // navbar-static-top
        $this->insert('{{%panel}}', [
            'id'                => 2,
            'context_id'        => 0,
            'title'             => 'navbar-static-top',
            'key'               => 'navbar-static-top'
        ]);
        // main-sidebar
        $this->insert('{{%panel}}', [
            'id'                => 3,
            'context_id'        => 0,
            'title'             => 'main-sidebar',
            'key'               => 'main-sidebar'
        ]);

//        'id'                => $this->primaryKey(),
//        'parent_id'         => $this->integer(),
//        'panel_id'          => $this->integer(),
//        'title'             => $this->string(50)->unique(),
//        'description'       => $this->string(255),
//        'key'               => $this->string(50)->unique(),
//        'slug'              => $this->string(50)->unique(),
//        'sort'              => $this->smallInteger()->unique(),
//        'status'            => $this->smallInteger()->defaultValue(true),
//        'richtext'          => $this->text()

        $this->insert('{{%panel_item}}', [
            'panel_id'          => 3,
            'title'             => 'Main',
            'options'           => "['class' => 'header']",
        ]);

        $this->insert('{{%panel_item}}', [
            'panel_id'          => 3,
            'title'             => 'Menu',
            'url'               => '/menu/index',
            'icon'              => '<i class="fa fa-sitemap"></i>'
        ]);

        $this->insert('{{%panel_item}}', [
            'panel_id'          => 3,
            'label'             => 'Setings',
            'url'               => '#',
            'icon'              => '<i class="fa fa-edit"></i>',
            'options'           => "['class' => 'treeview']",
        ]);

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_launch_author', '{{%launch}}');
        $this->dropForeignKey('fk_launch_updater', '{{%launch}}');
        $this->dropForeignKey('fk_launch_category', '{{%launch}}');
        $this->dropForeignKey('fk_template_launch', '{{%launch}}');
        $this->dropForeignKey('fk_launch_content_type', '{{%launch}}');
        $this->dropForeignKey('fk_launch_parent', '{{%launch}}');
        $this->dropForeignKey('fk_launch_like', '{{%launch}}');
        $this->dropForeignKey('fk_launch_visit', '{{%launch}}');
        $this->dropForeignKey('fk_panel_panel_item', '{{%panel_item}}');

        $this->dropTable('{{%launch}}');
        $this->dropTable('{{%template}}');
        $this->dropTable('{{%chunk}}');
        $this->dropTable('{{%snippet}}');
        $this->dropTable('{{%like}}');
        $this->dropTable('{{%visit}}');
        $this->dropTable('{{%content_type}}');
        $this->dropTable('{{%domain}}');
        $this->dropTable('{{%domain_key}}');
        $this->dropTable('{{%panel}}');
        $this->dropTable('{{%panel_item}}');

    }

}
