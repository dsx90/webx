<?php

use yii\db\Migration;
use yii\helpers\Json;

/**
 * Class m160101_000007_panel
 */
class m160101_000007_panel extends Migration
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
            'position'          => $this->smallInteger(),
        ], $tableOptions);

        // Содержимое панелей
        $this->createTable('{{%panel_item}}',[
            'id'                => $this->primaryKey(),
            'parent_id'         => $this->integer(),
            'panel_id'          => $this->integer(),
            'visible'           => $this->string(50)->defaultValue('null'),
            'title'             => $this->string(50),
            'description'       => $this->string(255),
            'icon'              => $this->string(50),
            'url'               => $this->string(50)->unique()->defaultValue(null),
            'options'           => $this->json(),
            'key'               => $this->string(50)->unique(),
            'slug'              => $this->string(50)->unique(),
            'position'          => $this->smallInteger(),
            'status'            => $this->smallInteger()->defaultValue(1),
            'richtext'          => $this->text(),
        ], $tableOptions);

        //$this->createIndex('m_index_panel_id_position', '{{%panel_item}}', 'panel_id, position', true);

        $this->createIndex('m_index_panel_id_title', '{{%panel_item}}', 'panel_id, title', true);

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
            [   'context_id',                    'title',            'key'],
            [
                [$this->context('admin'),   'Дашборд',          'dashboard'],
                [$this->context('site'),    'Верхнее меню',     'navbar-static-top'],
                [$this->context('admin'),   'Основной',         'main-sidebar']
            ]);

        $this->batchInsert('{{%panel_item}}',
            ['parent_id',                          'panel_id',                                 'position',   'title',            'key',        'options',                                 'url',                  'icon',                     'visible'],
            [
                [null,                             $this->panel('main-sidebar'),          1,            'Main',             'main',       Json::encode(['class' => 'header treeview']),null,                  'fa fa-home',               null],
                [null,                             $this->panel('main-sidebar'),          2,            'Настройки',        'settings',   Json::encode(['class' => 'header treeview']),null,                  'fa fa-sliders',            null],
                [null,                             $this->panel('main-sidebar'),          3,            'Модули',           'modules',    Json::encode(['class' => 'header treeview']),null,                  'fa fa-sitemap',            null],
                [null,                             $this->panel('navbar-static-top'),     1,            'Статистика',       'statistic',  Json::encode(['class' => 'header treeview']),null,                  'fa fa-pie-chart',          null],
                [null,                             $this->panel('navbar-static-top'),     2,            'Теги',             'tag',        null,                                       '/tag/index',           'fa fa-tags',               null],
                [null,                             $this->panel('navbar-static-top'),     3,            'Layout Module',    null,         null,                                       '/layout-module/index', 'fa fa-puzzle-piece',       'administrator'],
                [null,                             $this->panel('dashboard'),             1,            'Меню',             'menu',       null,                                       '/menu/index',          null,                       null],

            ]);

        $this->batchInsert('{{%panel_item}}',
            ['parent_id',                          'panel_id',                                 'position',   'title',            'key',        'options',                                 'url',                  'icon',                     'visible'],
            [
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     4,            'Group',            null,         null,                                       '/group',               'fa fa-angle-double-right', 'administrator'],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     5,            'Настройка модулей',null,         null,                                       '/module',              'fa fa-angle-double-right', 'administrator'],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     6,            'Gii',              null,         null,                                       '/gii',                 'fa fa-angle-double-right', 'YII_ENV_DEV'],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     7,            'Web shell',        null,         null,                                       '/webshell',            'fa fa-angle-double-right', 'administrator'],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     8,            'Менеджер файлов',  null,         null,                                       '/file-manager',        'fa fa-angle-double-right', null],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     9,            'DB manager',       null,         null,                                       '/db-manager/default',  'fa fa-angle-double-right', 'administrator'],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     10,           'Системная инф-ия', null,         null,                                       '/phpsysinfo/default',  'fa fa-angle-double-right', 'administrator'],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     11,           'Key storage',      null,         null,                                       '/key-storage',         'fa fa-angle-double-right', null],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     12,           'Cache',            null,         null,                                       '/service/cache',       'fa fa-angle-double-right', null],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     13,           'Clear assets',     null,         null,                                       '/service/clear-assets','fa fa-angle-double-right', null],
                [$this->parent('settings'),   $this->panel('navbar-static-top'),     14,           'Logs',             null,         null,                                       '/log',                 'fa fa-angle-double-right', null],
            ]);

        /*
        [
            'label' => Yii::t('backend', 'Logs'),
            'url' => ['/log/index'],
            'icon' => '<i class="fa fa-angle-double-right"></i>',
            'badge' => Log::find()->count(),
            'badgeOptions' => ['class' => 'label-danger'],
        ],*/
    }

    public function context($key)
    {
        return \common\models\Context::findOne(['key' => $key])->id;
    }

    public function panel($key)
    {
        return \backend\models\Panel::findOne(['key' => $key])->id;
    }

    public function parent($key)
    {
        return \common\models\PanelItem::findOne(['key' => $key])->id;
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
