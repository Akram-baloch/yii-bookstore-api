<?php

namespace app\controllers\api;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\user';
}
