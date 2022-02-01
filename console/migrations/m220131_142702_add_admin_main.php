<?php

use common\models\User;
use yii\base\BaseObject;
use yii\db\Migration;

/**
 * Class m220131_142702_add_admin_main
 */
class m220131_142702_add_admin_main extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'RadminTrial';
        $user->email = 'RadminTrial';
        $user->status = 10;
        $user->setPassword('44WCdF}Den#?');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if (!$user->save()) {
            var_dump(1);
            die;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220131_142702_add_admin_main cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220131_142702_add_admin_main cannot be reverted.\n";

        return false;
    }
    */
}
