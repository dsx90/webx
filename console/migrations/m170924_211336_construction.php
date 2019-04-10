<?php

use yii\db\Migration;

class m170924_211336_construction extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%construction}}', [
            'launch_id' => $this->integer()->unique()->notNull(),
            'content' => $this->text(),
            'price' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey(
          'fk-construction-launch_id',
          '{{%construction}}',
          'launch_id',
          '{{%launch}}',
          'id',
          'CASCADE',
          'RESTRICT'
        );

        $this->insert('{{%content_type}}', [
            'title'         => 'Construction',
            'name'          => 'Выполнение работ',
            'icon'          => 'fa fa-wrench',
            'status'        => '1',
            'model'         => 'common\modules\construction\models\Construction',
            'controller'    => 'common\modules\construction\controllers\admin\ConstructionController',
            'form'          => '@common/modules/construction/views/admin/construction/_cform',
        ]);

        $this->insert('{{%panel_item}}', [
            'panel_id'  => 2,
            'sort'      => 1,
            'title'     => 'Выполнение работ',
            'options'   => null,
            'url'       => '/construction',
            'icon'      => 'fa fa-product-hunt',
            'visible'   => null
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%construction}}');

        $this->delete('{{%content_type}}', [
            'title' => 'Construction',
        ]);
    }
}
