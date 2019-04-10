<?php

use yii\db\Migration;

/**
 * Class m190410_163142_panel
 */
class m160101_000009_panel extends Migration
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

        //Таблица панелей
        $this->createTable('{{%panel}}',[
            'id'                => $this->primaryKey(),
            'context_id'        => $this->integer(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'key'               => $this->string(50)->unique(),
            'status'            => $this->smallInteger()->defaultValue(1),
            'sort'              => $this->smallInteger(),
        ], $tableOptions);

        // Содержимое панелей
        $this->createTable('{{%panel_item}}',[
            'id'                => $this->primaryKey(),
            'parent_id'         => $this->integer(),
            'panel_id'          => $this->integer(),
            'visible'           => $this->string(50),
            'title'             => $this->string(50),
            'description'       => $this->string(255),
            'icon'              => $this->string(50),
            'url'               => $this->string(50)->unique()->defaultValue(null),
            'options'           => $this->string(255),
            'key'               => $this->string(50)->unique(),
            'slug'              => $this->string(50)->unique(),
            'sort'              => $this->smallInteger(),
            'status'            => $this->smallInteger()->defaultValue(1),
            'richtext'          => $this->text()
        ], $tableOptions);

        //TODO: Добавить уникальность по 2 ключам panel_id, sort
        //TODO: Добавить уникальность по 2 ключам panel_id, title

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

        $this->batchInsert('{{%panel}}',
            ['id', 'context_id', 'title', 'key'],
            [
                [1, 1,  'dashboard',            'dashboard'],
                [2, 2,  'navbar-static-top',    'navbar-static-top'],
                [3, 1,  'main-sidebar',         'main-sidebar']
            ]);

        $this->batchInsert('{{%panel_item}}',
            ['panel_id',    'sort', 'title',            'options',                                  'url',                  'icon',                     'visible'],
            [
                [3,          1,      'Main',             "['class' => 'header treeview']",           null,                    'fa fa-home',               null],
                [3,          1,      'Settings',         "['class' => 'header treeview']",           null,                    'fa fa-sitemap',            null],
                [1,          1,      'Меню',             null,                                       '/menu/index',          null,                       null],
                [2,          1,      'Tags',             null,                                       '/tag/index',           'fa fa-tags',               null],
                [2,          2,      'Layout Module',    null,                                       '/layout-module/index', 'fa fa-puzzle-piece',       'administrator'],
                [2,          3,      'Launch',           null,                                       '/launch',              'fa fa-angle-double-right', 'administrator'],
                [2,          4,      'Group',            null,                                       '/group',               'fa fa-angle-double-right', 'administrator'],
                [2,          5,      'Template',         null,                                       '/template',            'fa fa-angle-double-right', 'administrator'],
                [2,          6,      'Chunk',            null,                                       '/chunk',               'fa fa-angle-double-right', 'administrator'],
                [2,          7,      'Snippet',          null,                                       '/snippet',             'fa fa-angle-double-right', 'administrator'],

            ]);

        /*
        [
            'label' => Yii::t('backend', 'Module'),
            'url' => ['/module'],
            'icon' => '<i class="fa fa-angle-double-right"></i>',
            'visible' => Yii::$app->user->can('administrator'),
        ],
        [
            'label' => 'Gii',
            'url' => ['/gii'],
            'icon' => '<i class="fa fa-angle-double-right"></i>',
            'visible' => YII_ENV_DEV,
        ],
        [
            'label' => 'Web shell',
            'url' => ['/webshell'],
            'icon' => '<i class="fa fa-angle-double-right"></i>',
            'visible' => Yii::$app->user->can('administrator'),
        ],
        ['label' => Yii::t('backend', 'File manager'), 'url' => ['/file-manager/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
        [
            'label' => Yii::t('backend', 'DB manager'),
            'url' => ['/db-manager/default/index'],
            'icon' => '<i class="fa fa-angle-double-right"></i>',
            'visible' => Yii::$app->user->can('administrator'),
        ],
        [
            'label' => Yii::t('backend', 'System information'),
            'url' => ['/phpsysinfo/default/index'],
            'icon' => '<i class="fa fa-angle-double-right"></i>',
            'visible' => Yii::$app->user->can('administrator'),
        ],
        ['label' => Yii::t('backend', 'Key storage'), 'url' => ['/key-storage/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
        ['label' => Yii::t('backend', 'Cache'), 'url' => ['/service/cache'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
        ['label' => Yii::t('backend', 'Clear assets'), 'url' => ['/service/clear-assets'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
        [
            'label' => Yii::t('backend', 'Logs'),
            'url' => ['/log/index'],
            'icon' => '<i class="fa fa-angle-double-right"></i>',
            'badge' => Log::find()->count(),
            'badgeOptions' => ['class' => 'label-danger'],
        ],*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_panel_panel_item', '{{%panel_item}}');

        $this->dropTable('{{%panel}}');
        $this->dropTable('{{%panel_item}}');
    }

}
