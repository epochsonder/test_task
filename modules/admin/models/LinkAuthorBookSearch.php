<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\LinkAuthorBook;

/**
 * LinkAuthorBookSearch represents the model behind the search form of `app\modules\admin\models\LinkAuthorBook`.
 */
class LinkAuthorBookSearch extends LinkAuthorBook
{
    /**
     * {@inheritdoc}
     */
    public $bookName;
    public $authorName;

    public function rules()
    {
        return [
            [['id', 'author', 'book'], 'integer'],
            [['bookName','authorName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LinkAuthorBook::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([

            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                ],
                'bookName' => [
                    'asc' => ['book.name' => SORT_ASC],
                    'desc' => ['book.name' => SORT_DESC],
                ],
                'authorName' => [
                    'asc' => ['author.fio' => SORT_ASC],
                    'desc' => ['author.fio' => SORT_DESC],
                ],
            ]
        ]);

//        $this->load($params);
        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных
             * для работы сортировки.
             */
            $query
                ->joinWith(['bookId'])
                ->joinWith(['authorId'])
            ;
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->joinWith(['bookId' => function ($q) { $q->where('book.name LIKE "%' . $this->bookName . '%"'); }])
            ->joinWith(['authorId' => function ($q) { $q->where('author.fio LIKE "%' . $this->authorName . '%"'); }])
        ;

        return $dataProvider;
    }
}
