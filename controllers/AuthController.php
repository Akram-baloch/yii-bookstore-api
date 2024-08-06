<?php

namespace app\controllers;
use Yii;
use app\models\User;
use yii\web\Response;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:4200'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
            'except' => ['login', 'signup', 'options', 'logout','profile'],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['options'] = [
            'class' => 'yii\rest\OptionsAction',
        ];
        return $actions;
    }

    public function actionOptions($id = null)
    {
        Yii::$app->response->statusCode = 200;
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
    public function actionLogout()
    {
        $userID = Yii::$app->user->identity;
        $userModel = User::find()->where(['id' => $userID])->one();
        if (!empty($userModel)) {
            $userModel->token = NULL;
            $userModel->save(false);
        }
        Yii::$app->user->logout(false);
    }

    public function actionProfile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user = Yii::$app->user->identity;

        if ($user) {
            return $this->asJson(['success' => true, 'username' => $user->name, 'email' => $user->email]);
        } else {
            return $this->asJson(['success' => false, 'message' => 'No user logged in']);
        }
    }
}