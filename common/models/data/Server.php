<?php

namespace common\models\data;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "server".
 *
 * @property int $id
 * @property string $name Название
 * @property string $error Описание ошибки
 *
 *
 * @property Account[] $accounts
 */
class Server extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'server';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['error'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'error' => 'Описание ошибки',
        ];
    }

    /**
     * Gets query for [[Accounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::class, ['server_id' => 'id']);
    }

    public static function createOrFindServer($name)
    {
        $server = Server::findOne(['name' => $name]);

        if ($server === null) {
            $server = new Server([
                'name' => $name,
            ]);
        }

        $server->error = null;


        if (!$server->save()) {
            return null;
        }

        return $server;
    }

    public function getCountAccount()
    {
        return Account::find()
            ->where([
                'server_id' => $this->id,
                'is_deleted' => 0,
            ])
            ->count();
    }

    public function getCountWithOutCapchaAccount()
    {
        return Account::find()
            ->where([
                'server_id' => $this->id,
                'is_deleted' => 0,
                'type' => Account::TYPE_WITHOUT_CAPCHA,
            ])
            ->count();
    }

    public function getCountWithCapchaAccount()
    {
        return Account::find()
            ->where([
                'server_id' => $this->id,
                'is_deleted' => 0,
                'type' => Account::TYPE_WITH_CAPCHA,
            ])
            ->count();
    }

    public static function getAllStat($startPeriod, $endPeriod)
    {
        $servers = self::find()->all();
        $result = [];

        /* @var Server $server */
        foreach ($servers as $server) {
            $query = Account::find()
                ->where([
                    'server_id' => $server->id,
                    'is_deleted' => 0,
                ])
                ->andFilterWhere(['>=', 'created_at', $startPeriod])
                ->andFilterWhere(['<=', 'created_at', $endPeriod]);

            $queryAll = clone($query);
            $queryWithOut = clone($query);
            $queryWith = clone($query);

            $result[] = [
                'server_id' => $server->id,
                'all' => $queryAll->count(),
                'withOutCapcha' => $queryWithOut
                    ->andWhere([
                        'type' => Account::TYPE_WITHOUT_CAPCHA,
                    ])->count(),
                'withCapcha' => $queryWith
                    ->andWhere([
                        'type' => Account::TYPE_WITH_CAPCHA,
                    ])->count(),
            ];
        }

        return $result;
    }
}
