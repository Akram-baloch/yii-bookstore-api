<?php
namespace app\models;
class Author extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'authors';
    }
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['author_id' => 'id']);
    }
}
