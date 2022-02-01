<?php

use common\models\data\Account;
use yii\db\Migration;

/**
 * Class m220201_062155_update_table_account
 */
class m220201_062155_update_table_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Account::tableName(), 'server_id', $this->integer()->notNull()->comment('Сревер'));

        $this->addForeignKey('fk_account_server', 'account', 'server_id', 'server', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220201_062155_update_table_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220201_062155_update_table_account cannot be reverted.\n";

        return false;
    }
    */
}
