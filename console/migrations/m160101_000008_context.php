<?php

use yii\db\Migration;

/**
 * Class m190410_162905_context
 */
class m160101_000008_context extends Migration
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

        //Таблица доменов
        $this->createTable('{{%context}}',[
            'id'                => $this->primaryKey(),
            'key'               => $this->string()->unique(),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'sort'              => $this->smallInteger(),
            'slug'              => $this->string(50)->unique()
        ], $tableOptions);

        // Таблица [ключей => значений] для домена
        // Номера телефонов, График рабочего времени, Местоположение, Адрес, Настройки и т.д
        $this->createTable('{{%context_key}}',[
            'key'               => $this->string(50),
            'context_id'        => $this->integer(11),
            'namespace'         => $this->string(50),
            'title'             => $this->string(50)->unique(),
            'description'       => $this->string(255),
            'value'             => $this->text(),
        ], $tableOptions);

        // Связь ключей с доменом
        $this->addForeignKey(
            'fk_context_context_key',
            '{{%context_key}}',
            'context_id',
            '{{%context}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->batchInsert('{{%context}}',
            ['id', 'title', 'key', 'slug'],
            [
                [1, 'Admin Panel',   'admin',    'be'],
                [2, 'Site',          'site',     '/'],

            ]);

        $this->batchInsert('{{%context_key}}',
            ['context_id', 'title', 'namespace', 'description', 'key', 'value'],
            [
                [2, 'Регистрация через фронтенд',            'frontend',     'Регистрация через фронтенд',           'frontend.registration',           1],
                [2, 'Подтверждение по электронной почте',    'frontend',     'Подтверждение по электронной почте',   'frontend.email-confirm',          1],
                [1, 'Фиксированное меню',                    'backend',      'Фиксированное меню',                   'backend.layout-fixed',            0],
                [1, 'Контейнер меню',                        'backend',      'Контейнер меню',                       'backend.layout-boxed',            0],
                [1, 'Сжатое меню',                           'backend',      'Сжатое меню',                          'backend.layout-collapsed-sidebar',0],
                [1, 'Маленькое меню',                        'backend',      'Маленькое меню',                       'backend.layout-mini-sidebar',     0],
                [2, 'Номер телефона',                        'frontend',     'Номер телефона',                       'site.phone',                      '89998887766'],
                [1, 'Тема админ панели',                     'backend',      'Тема админ панели',                    'backend.theme-skin',              'skin-blue'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%context}}');
        $this->dropTable('{{%context_key}}');
    }
}
