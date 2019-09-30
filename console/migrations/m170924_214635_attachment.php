<?php

use yii\db\Migration;

class m170924_214635_attachment extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%attachment}}',[
            'id'            => $this->primaryKey(),
            'table'         => $this->string(),
            'link_id'       => $this->integer(),
            'path'          => $this->string(),
            'base_url'      => $this->string(),
            'type'          => $this->string(),
            'size'          => $this->integer(),
            'name'          => $this->string(),
            'create_at'     => $this->integer()
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%attachment}}');
    }
}
