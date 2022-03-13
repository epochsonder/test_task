<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Book;
use app\modules\admin\models\LinkAuthorBook;
use app\modules\admin\models\LinkAuthorBookSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinkAuthorBookController implements the CRUD actions for LinkAuthorBook model.
 */
class LinkAuthorBookController extends Controller
{
    /**
     * @inheritDoc
     */
    public $layout = 'main';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all LinkAuthorBook models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LinkAuthorBookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LinkAuthorBook model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LinkAuthorBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new LinkAuthorBook();

        $book_empty_author = new Query;
        $book_empty_author->select(['name' , 'book.id'])
            ->from('book')
            ->leftJoin('link_author_book', 'link_author_book.book = book.id')
            ->where(['is','link_author_book.book', null]);
        $book_empty_author = $book_empty_author->createCommand();
        $book_empty_author = $book_empty_author->queryAll();

        if (!empty($book_empty_author)){
            foreach ($book_empty_author as $book){
                $books[$book['id']]=$book['name'];
            }
        }


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'books' => $books,
        ]);
    }

    /**
     * Updates an existing LinkAuthorBook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LinkAuthorBook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LinkAuthorBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LinkAuthorBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LinkAuthorBook::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
