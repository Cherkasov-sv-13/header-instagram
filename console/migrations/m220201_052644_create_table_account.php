<?php

use yii\db\Migration;

/**
 * Class m220201_052644_create_table_account
 */
class m220201_052644_create_table_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('account', [
            'id' => $this->primaryKey(),
            'data' => $this->text()->notNull()->comment('Данные аккаунта'),
            'type' => $this->integer()->comment('Тип аккаунта'),
            'created_at' => $this->integer()->comment('Дата регистрации'),
            'is_deleted' => $this->boolean()->defaultValue(0)->comment('Архив'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220201_052644_create_table_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220201_052644_create_table_account cannot be reverted.\n";

        return false;
    }
    */
}
