<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "link_author_book".
 *
 * @property int $id
 * @property int $author
 * @property int $book
 */
class LinkAuthorBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link_author_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author', 'book'], 'required'],
            [['author', 'book'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Автор',
            'book' => 'Книга',
            'authorName' => 'Автор',
            'bookName' => 'Книга',
        ];
    }

    public function getBookId()
    {
        return $this->hasOne(Book::className(), ['id' => 'book']);
    }

    public function getBookName()
    {
        return $this->bookId->name;
    }

    public function getAuthorId()
    {
        return $this->hasOne(Author::className(), ['id' => 'author']);
    }

    public function getAuthorName()
    {
        return $this->authorId->fio;
    }
}
