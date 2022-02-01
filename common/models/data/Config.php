<?php

namespace common\models\data;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name Название
 * @property string $slug Код
 * @property string|null $value Значение
 */
class Config extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%config}}';
    }

    public static function getValueBySlug($slug)
    {
        $configValue = static::find()
            ->select('value')
            ->where(['slug' => $slug])
            ->limit(1)
            ->scalar();

        return $configValue !== null ? $configValue : null;
    }

    public static function telegramChatIdIsValid($chatId): bool
    {
        try {
            Yii::$app->telegram->getChat([
                'chat_id' => $chatId,
            ]);

            return true;
        } catch (\Exception $e) {
            return $e->getCode() === 0;
        }
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['value'], 'string'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Код',
            'value' => 'Значение',
        ];
    }

    public static function getDebugStr()
    {
        return "\n\n" . 'Приложение: ' . self::getValueBySlug('name-project') . "\n" .
            'Компания: ' . self::getValueBySlug('name-company') . "\n" .
            'Версия: ' . self::getValueBySlug('version') . "\n" .
            'Сервер: ' . Yii::$app->request->hostInfo . "\n\n" .
            'Url: ' . Yii::$app->request->hostInfo . '/admin' . "\n\n";
    }
}
