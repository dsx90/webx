<?php

use yii\db\Migration;

/**
 * Class m191028_180938_launch_links
 */
class m191028_180938_launch_links extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%launch_links}}', [
            'launch_id' => $this->integer(),
            'parent_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-self-launch-launch_links', '{{%launch_links}}', '[[launch_id]]', '{{%launch}}', 'id');
        $this->addForeignKey('fk-parent-launch-launch_links','{{%launch_links}}', '[[parent_id]]', '{{%launch}}', 'id' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-self-launch-launch_links', '{{%launch_links}}');
        $this->dropForeignKey('fk-parent-launch-launch_links', '{{%launch_links}}');

        $this->dropTable('{{%launch_links}}');
    }
}
