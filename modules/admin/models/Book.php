<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
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
            'authorName' => 'Автор',
        ];
    }

    public function getAuthorLink()
    {
        return LinkAuthorBook::find()->where(['book'=>$this->id])->one();
    }
    public function getAuthor()
    {
        return Author::find()->where(['id'=>$this->authorLink])->one();
    }
    public function getAuthorName()
    {
        return $this->author->fio;
    }
}
