<?php

use common\models\Panel;
use yii\db\Migration;

/**
 * Class m190924_184053_pets
 */
class m190924_184053_pets extends Migration
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

        /** Класс */
        $this->createTable('{{%breed}}', [
            'launch_id' => $this->integer(),
        ]);

        /** Животные */
        $this->createTable('{{%pet}}', [
            'launch_id'     => $this->integer()->comment('Порода'),
            'ties_id'       => $this->integer()->comment('Связь родителей'),
            'sex'           => $this->boolean()->comment('Пол'),
            'birth_date'    => $this->integer()->comment('Дата рождения'),
            'status'        => $this->smallInteger()->comment('Статус')
        ], $tableOptions);

        /**  Связь */
        $this->createTable('{{%ties_pets}}', [
            'id'            => $this->primaryKey(),
            'male'          => $this->integer()->comment('Самка'),
            'female'        => $this->integer()->comment('Самец'),
            'data'          => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%offer_pet}}', [
            'offer_id'       => $this->integer(),
            'pet_id'         => $this->integer(),
            'status'         => $this->smallInteger(), //Продажа, Бронь, Продан, Снят, Сведение
        ], $tableOptions);

//        $this->addForeignKey('fk-ties_pets-pet_male', '{{%ties_pets}}', '[[male]]', '{{%pet}}', '[[launch_id]]');
//        $this->addForeignKey('fk-ties_pets-pet_female', '{{%ties_pets}}', '[[female]]', '{{%pet}}', '[[launch_id]]');

        $this->addForeignKey('fk-pet_ties_pets', '{{%pet}}', '[[ties_id]]', '{{%ties_pets}}', '[[id]]');

        $this->addForeignKey('fk-offer_pet-offer', '{{%offer_pet}}', '[[offer_id]]', '{{%offer}}', '[[id]]');
//        $this->addForeignKey('fk-offer_pet-pet', '{{%offer_pet}}', '[[pet_id]]', '{{%pet}}', '[[launch_id]]');

        $this->insert('{{%panel_item}}', [
            'parent_id' => null,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Животные',
            'key'       => 'pet',
            'options'   => null,
            'url'       => '/pet',
            'icon'      => 'fa fa-paw',
            'visible'   => null
        ]);

        $this->insert('{{%panel_item}}', [
            'parent_id' => null,
            'panel_id'  => Panel::findOne(['key' => 'navbar-static-top'])->id,
            'position'  => 1,
            'title'     => 'Свзязи',
            'key'       => 'ties_pets',
            'options'   => null,
            'url'       => '/ties-pets',
            'icon'      => 'fa fa-paw',
            'visible'   => null
        ]);

        $this->insert('{{%content_type}}', [
            'module'        => 'pet',
            'key'           => 'pet',
            'name'          => 'Животные',
            'icon'          => 'fa fa-paw',
            'status'        => '1'
        ]);

        $this->insert('{{%content_type}}', [
            'module'        => 'pet',
            'key'           => 'breed',
            'name'          => 'Порода',
            'icon'          => 'fa fa-paw',
            'status'        => '1'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropForeignKey('fk-offer_pet-pet', '{{%offer_pet}}');
        $this->dropForeignKey('fk-offer_pet-offer', '{{%offer_pet}}');
        $this->dropForeignKey('fk-pet_ties_pets', '{{%pet}}');
//        $this->dropForeignKey('fk-ties_pets-pet_female', '{{%ties_pets}}');
//        $this->dropForeignKey('fk-ties_pets-pet_male', '{{%ties_pets}}');

        $this->dropTable('{{%breed}}');
        $this->dropTable('{{%pet}}');
        $this->dropTable('{{%ties_pets}}');
        $this->dropTable('{{%offer_pet}}');

        $this->delete('{{%panel_item}}', ['key' => 'pet']);
        $this->delete('{{%panel_item}}', ['key' => 'ties_pets']);

        $this->delete('{{%content_type}}', ['key' => 'pet']);
        $this->delete('{{%content_type}}', ['key' => 'breed']);
    }
}
