<?php

namespace common\models\data;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property string $data Данные аккаунта
 * @property int|null $type Тип аккаунта
 * @property int|null $created_at Дата регистрации
 * @property int|null $is_deleted Архив
 * @property int|null $server_id Сервер
 */
class Account extends \yii\db\ActiveRecord
{
    public const TYPE_WITHOUT_CAPCHA = 1;
    public const TYPE_WITH_CAPCHA = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'required'],
            [['data'], 'string'],
            [['type', 'created_at', 'is_deleted', 'server_id'], 'integer'],
            [
                ['server_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Server::class,
                'targetAttribute' => ['server_id' => 'id'],
            ],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
            'softDelete' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'is_deleted' => true,
                ],
                'replaceRegularDelete' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Данные',
            'type' => 'Тип',
            'server_id' => 'Сервер',
            'created_at' => 'Дата регистрации',
            'is_deleted' => 'Архив',
        ];
    }

    public function getServer()
    {
        return $this->hasOne(Server::class, ['id' => 'server_id']);
    }

    public static function typeList()
    {
        return [
            self::TYPE_WITHOUT_CAPCHA => 'Успешные',
            self::TYPE_WITH_CAPCHA => 'Успешные перечеканые',
        ];
    }

    public function getTypeStr()
    {
        return self::typeList()[$this->type];
    }

    public static function getContentForFile($type, $server_id = null)
    {
        $offset = 0;
        $limit = 1000;
        $content = '';

        $accountIds = [];

        do {
            $accounts = Account::find()
                ->select(['id', 'data'])
                ->where([
                    'type' => $type,
                    'is_deleted' => 0,
                ])
                ->andFilterWhere(['server_id' => $server_id])
                ->limit($limit)
                ->offset($offset * $limit)
                ->all();

            foreach ($accounts as $account) {
                $accountIds[] = $account['id'];
                $content .= $account['data'] . PHP_EOL;
            }

            $offset++;
        } while ($accounts);

        Account::updateAll(['is_deleted' => 1], ['id' => $accountIds]);

        return $content;
    }

    public static function getCount()
    {
        return Account::find()
            ->where([
                'is_deleted' => 0,
            ])
            ->count();
    }

    public static function getCountWithOutCapcha()
    {
        return Account::find()
            ->where([
                'is_deleted' => 0,
                'type' => Account::TYPE_WITHOUT_CAPCHA,
            ])
            ->count();
    }

    public static function getCountWithCapcha()
    {
        return Account::find()
            ->where([
                'is_deleted' => 0,
                'type' => Account::TYPE_WITH_CAPCHA,
            ])
            ->count();
    }
}
