<?php

namespace app\controllers;

use app\models\Book;
use app\models\UserSQL;
use app\modules\admin\models\LinkAuthorBook;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($author = null, $page = null, $size = 2)
    {
        if ($author){
            $author_query = ['=','author',$author];
        }else{
            $author_query = null;
        }

        $all_books = new Query;
        $all_books
            ->select(['`fio`,`name`,`author`.`id` as author_id'])
            ->from('link_author_book')
            ->leftJoin('book', 'link_author_book.book=book.id')
            ->leftJoin('author', 'link_author_book.author=author.id')
            ->where($author_query);

        $countQuery = clone $all_books;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $size]);
        $pages->pageSizeParam = false;

        $all_books
            ->offset($pages->offset)
            ->limit($pages->limit);



        $all_books = $all_books->createCommand();
        $all_books = $all_books->queryAll();


        return $this->render('index', [
            'models' => $all_books,
            'pages' => $pages,
        ]);
    }

    public function actionPermissionAdmin($user)
    {
        $auth = \Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $auth->assign($admin, $user);

        return $this->redirect('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserSQL();
        if ($model->load(Yii::$app->request->post())) {

            $model->fio = trim($model->fio);
            $model->email = trim($model->email);
            $model->password = \Yii::$app->security->generatePasswordHash($model->password);
            $model->save();

            return $this->goBack();
        }


        return $this->render('registration', [
            'model' => $model,
        ]);

    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->login();
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
