<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }
    public function rules()
    {
        return [
            [['name', 'password', 'auth_key', 'email'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'access_token', 'email'], 'string', 'max' => 191],
            [['password'], 'string', 'min' => 8, 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['role','in','range' =>['user','admin']],
        ];
    }
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
            'role' => 'Role',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['name' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isAttributeChanged('password')) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }
}
