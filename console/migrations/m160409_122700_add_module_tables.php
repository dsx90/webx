<?php

use yii\db\Migration;

class m160409_122700_add_module_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%module}}',[
            'id'            => $this->primaryKey(),
            'name'          => $this->string()->notNull(),
            'version_id'    => $this->string(),
            'source'        => $this->string()->notNull()
        ], $tableOptions);

        $this->createTable('{{%module_version}}',[
            'id'            => $this->primaryKey(),
            'name'          => $this->string()->notNull(),
            'source'        => $this->string()->notNull(),
            'module_id'     => $this->string()->notNull()
        ], $tableOptions);


//        $this->addForeignKey(
//            'fk_module_module_version',
//            '{{%module}}',
//            'version_id',
//            '{{%module_version}}',
//            'id'
//        );
//
//        $this->addForeignKey(
//            'fk_module_version_module',
//            '{{%module_version}}',
//            'module_id',
//            '{{%module}}',
//            'id'
//        );


        // TODO: TEST
//        $this->batchInsert('module', ['id', 'name','source'], [
//            ['example_billing', 'Биллинг', '\app\modules\example_billing\ExampleBilling'],
//            ['example_tracker', 'Трекер', '\app\modules\example_tracker\ExampleTracker'],
//        ]);
//        $this->batchInsert('module_version', ['id', 'module_id', 'name', 'source'], [
//            ['v1', 'example_billing', 'Версия 1', '\app\modules\example_billing\modules\v1\V1'],
//            ['v2', 'example_billing', 'Версия 2', '\app\modules\example_billing\modules\v2\V2'],
//            ['v1', 'example_tracker', 'Версия 1', '\app\modules\example_tracker\modules\v1\V1'],
//            ['v2', 'example_tracker', 'Версия 2', '\app\modules\example_tracker\modules\v2\V2'],
//        ]);
//        $this->update('module',['version_id'=>'v1']);
        //
    }
    public function safeDown()
    {
        $this->dropForeignKey('fk_module_module_version','module');
        $this->dropForeignKey('fk_module_version_module','module_version');

        $this->dropTable('module_version');
        $this->dropTable('module');
    }
}