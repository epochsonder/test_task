<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $fio
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 255],
            [['fio'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'count' => 'Количество книг',
        ];
    }
    public function getCount()
    {
        return LinkAuthorBook::find()->where(['author'=>$this->id])->count();
    }
}
