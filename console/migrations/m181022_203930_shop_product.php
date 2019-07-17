<?php

use yii\db\Migration;

/**
 * Class m181022_203930_product
 */
class m181022_203930_shop_product extends Migration
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

        //Таблица полей категории техники
        $this->createTable('{{%product}}', [
            'launch_id'             => $this->integer()->unique()->notNull(),
            'content'               => $this->text(),
            'price'                 => $this->money(),
            'old_price'             => $this->integer(),
            'status'                => $this->smallInteger(),
            'amount'                => $this->smallInteger()
        ], $tableOptions);

        $this->createTable('{{%order_product}}', [
            'id'                    => $this->primaryKey(),
            'product_id'            => $this->integer()->notNull(),
            'price'                 => $this->money(),
            'status'                => $this->smallInteger(),
            'amount'                => $this->smallInteger()
        ], $tableOptions);

        $this->addForeignKey(
            'fk-product-launch_id',
            '{{%product}}',
            'launch_id',
            '{{%launch}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->insert('{{%content_type}}', [
            'title'         => 'Product',
            'name'          => 'Продукт',
            'icon'          => 'fa fa-wrench',
            'status'        => '1',
            'model'         => 'common\modules\product\models\Product',
            'controller'    => 'common\modules\product\controllers\admin\ProductController',
            'form'          => '@common/modules/product/views/admin/product/_cform',
        ]);

        $this->insert('{{%panel_item}}', [
            'parent_id' => 3,
            'panel_id'  => 2,
            'position'  => 1,
            'title'     => 'Продукты',
            'options'   => null,
            'url'       => '/product',
            'icon'      => 'fa fa-product-hunt',
            'visible'   => null
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_product}}');
    }
}
