<?php

use common\models\data\Config;
use yii\db\Migration;

/**
 * Class m220131_150842_create_table_config
 */
class m220131_150842_create_table_config extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('config', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'slug' => $this->string()->notNull()->comment('Код'),
            'value' => $this->text()->comment('Значение'),
        ]);

        Yii::$app->db->createCommand()->batchInsert(Config::tableName(), ['name', 'slug', 'value'], [
            ['Токен телеграм бота', 'token-bot', ''],
            ['Чат телеграмм', 'telegram-chat', ''],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220131_150842_create_table_config cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220131_150842_create_table_config cannot be reverted.\n";

        return false;
    }
    */
}
