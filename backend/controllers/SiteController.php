<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\User;
use common\models\Board;
use common\models\Column;
use common\models\Ticket;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'initialize', 'index'],
                        'allow' => true,
                        //'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                        'matchCallback' => function($rule, $action) {
                            return \Yii::$app->user->isGuest AND User::findDemoUser();
                        }
                    ],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionInitialize() {
        //return $this->render('initialize');

        //Created new Demo User
        $user = new User();
        $user->createDemoUser();

        // Board Creation requires a logged in user, therefore login the newly created user
        $login = new LoginForm();
        $login->username = $user->username;
        $login->password = $user->password;
        $login->login();

        //Create Demo Board
        $board = new Board();
        $board->createDemoBoard();

        $user->board_id = $board->id;
        $user->update();

        //Create Demo Columns
        $column = new Column();
        $column->createDemoColumns($board->id);

        //Create Demo Tickets
        $column = new Ticket();
        $column->createDemoTickets($board->id);

        return $this->goHome();
    }
}
