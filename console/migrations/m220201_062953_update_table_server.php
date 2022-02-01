<?php

use common\models\data\Server;
use yii\db\Migration;

/**
 * Class m220201_062953_update_table_server
 */
class m220201_062953_update_table_server extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Server::tableName(), 'error', $this->text()->comment('Описание ошибки'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220201_062953_update_table_server cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220201_062953_update_table_server cannot be reverted.\n";

        return false;
    }
    */
}
