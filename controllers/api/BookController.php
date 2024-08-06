<?php

namespace app\controllers\api;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\Book;

class BookController extends ActiveController
{
    public $modelClass = 'app\models\Book';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \app\components\Cors::class,
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index'], $actions['view']);

        return $actions;
    }

    public function actionIndex()
    {
        $modelClass = $this->modelClass;

        $books = $modelClass::find()->with(['author', 'category'])->all();
        $response = [];

        foreach ($books as $book) {
            $response[] = [
                'id' => $book->id,
                'name' => $book->name,
                'image' => $book->image,
                'description' => $book->description,
                'author' => $book->author->name,
                'category' => $book->category->name,
                'price' => $book->price,
                'number_of_pages' => $book->number_of_pages,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
                'deleted_at' => $book->deleted_at,
            ];
        }

        return $response;
    }

    public function actionView($id)
    {
        $modelClass = $this->modelClass;

        $book = $modelClass::find()->where(['id' => $id])->with(['author', 'category'])->one();

        if ($book) {
            return [
                'id' => $book->id,
                'name' => $book->name,
                'image' => $book->image,
                'description' => $book->description,
                'author' => $book->author->name,
                'category' => $book->category->name,
                'price' => $book->price,
                'number_of_pages' => $book->number_of_pages,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
                'deleted_at' => $book->deleted_at,
            ];
        }

        throw new \yii\web\NotFoundHttpException("Book not found");
    }
}