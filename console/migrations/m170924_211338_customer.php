<?php

use yii\db\Migration;

class m170924_211338_customer extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /**
         * New Table
         */
        $this->createTable('{{%customer}}', [
            'id'                    => $this->primaryKey(),
            'owner_id'              => $this->integer(),
            'manager_id'            => $this->integer(),
            // Информация о заказчике
            'name'                  => $this->string(50),
            'phone'                 => $this->string(18),
            'email'                 => $this->string(50),
            'comment'               => $this->text(),
            'comment_manager'       => $this->text(),
            'status'                => $this->smallInteger(),
            'order_get'             => $this->smallInteger(),
            // Информация о задолжности
            'debt'                  => $this->integer(),
            'debt_time'             => $this->integer(),
            'passport'              => $this->string(),
            'company'               => $this->string(),
            'iin'                   => $this->integer(),
            'duration_time'         => $this->integer(),
            'thumbnail'             => $this->string(),
            'thumbnail_base_url'    => $this->string(),
            'thumbnail_path'        => $this->string(),
        ], $tableOptions);

        /**
         * New Foreign Key Index
         */
        $this->addForeignKey(
            'fk-owner-user',
            '{{%customer}}',
            'owner_id',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-manager-user',
            '{{%customer}}',
            'manager_id',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }

}
