<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $auth_key
 * @property string|null $access_token
 * @property string $email
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'password', 'auth_key', 'email'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'access_token', 'email'], 'string', 'max' => 191],
            [['password'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
