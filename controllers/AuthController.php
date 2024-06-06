<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;

class AuthController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login', 'signup'],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);

        if ($user) {
            if ($user->validatePassword($password)) {
                $user->setAuthKey();
                if ($user->save()) {
                    unset($user->password);
                    return $this->asJson(['success' => true, 'token' => $user->auth_key, 'user' => $user]);
                }
                return $this->asJson(['success' => false, 'message' => 'Unauthorized, Invalid credentials']);
            } else {
                return $this->asJson(['success' => false, 'message' => 'Unauthorized, Invalid credentials']);
            }
        } else {
            return $this->asJson(['success' => false, 'message' => 'Unauthorized, Invalid credentials']);
        }
    }

    public function actionSignup()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        $email = Yii::$app->request->post('email');
        if (!$username || !$password || !$email) {
            return $this->asJson(['success' => false, 'message' => 'All fields are required']);
        }

        $user = new User();
        $user->name = $username;
        $user->password = $password;
        $user->email = $email;
        $user->setAuthKey();

        if ($user->save()) {
            unset($user->password);
            return $this->asJson(['success' => true, 'user' => $user]);
        } else {
            return $this->asJson(['success' => false, 'message' => 'Failed to create user', 'errors' => $user->errors]);
        }
    }

    // public function actionLogout()
    // {
    //     Yii::$app->response->format = Response::FORMAT_JSON;

    //     $user = Yii::$app->user->identity;

    //     if ($user) {
    //         $user->auth_key = null;
    //         if ($user->save()) {
    //             return $this->asJson(['success' => true, 'message' => 'Logged out successfully']);
    //         } else {
    //             return $this->asJson(['success' => false, 'message' => 'Failed to logout', 'errors' => $user->errors]);
    //         }
    //     } else {
    //         return $this->asJson(['success' => false, 'message' => 'No user logged in']);
    //     }
    // }

    public function actionProfile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user = Yii::$app->user->identity;

        if ($user) {
            return $this->asJson(['success' => true, 'username' => $user->name,'email'=>$user->email]);
        } else {
            return $this->asJson(['success' => false, 'message' => 'No user logged in']);
        }
    }
}
