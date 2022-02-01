<?php

namespace common\helpers;

use common\models\data\Config;
use Yii;

class TelegramHelper
{
    public static function sendMessage($params)
    {
        Yii::$app->telegram->botToken = Config::getValueBySlug('token-bot');
        Yii::$app->telegram->sendMessage($params);
    }
}
