<?php

namespace app\controllers\api;

use yii\rest\ActiveController;

class AuthorController extends ActiveController
{
    public $modelClass = 'app\models\author';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \app\components\Cors::class,
            ],
        ]);
    }
}