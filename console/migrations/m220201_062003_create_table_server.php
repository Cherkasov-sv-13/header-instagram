<?php

use yii\db\Migration;

/**
 * Class m220201_062003_create_table_server
 */
class m220201_062003_create_table_server extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('server', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull()->comment('Название'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220201_062003_create_table_server cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220201_062003_create_table_server cannot be reverted.\n";

        return false;
    }
    */
}
