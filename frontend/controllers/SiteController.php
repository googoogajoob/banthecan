<?php
namespace frontend\controllers;

use Yii;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\db\Query;
use common\models\Ticket;
use common\models\Task;
use common\models\Resolution;
use common\models\SiteNews;
use common\models\Board;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            //Why is this needed?
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
    public function actions() {

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

    public function actionIndex() {

        if (YII_ENV_DEMO and Yii::$app->user->isGuest) {
            $session = Yii::$app->session;
            $session->setFlash('info',
                'You can create demo data in the <a href="http://demo.admin.ban-the-can.net/"><strong>admin section</strong></a> or <a href="/site/login"><strong>login</strong></a> as a demo user.');
        }

        if (YII_ENV_DEMO) {
            return $this->render('index-demo');
        } else {
            $activeBoard = Board::getCurrentActiveBoard();
            $boardActivity = [];
            $newTickets = [];
            $news = [];
            $tasks = [];
            $kanBanOverview = $this->getUserOverview();
            if ($activeBoard) {
                $frontPageTimespan = time();
                $frontPageTimespan -= isset(Yii::$app->params['frontPageTimespan']) ? Yii::$app->params['frontPageTimespan'] : 604800; //Default Seconds in 7 days 60*60*24*7 = 604800;
                $query = new Query;

                $backlogActive = $query
                    ->from(Ticket::tableName())
                    ->where(['>', 'updated_at', $frontPageTimespan])
                    ->andWhere(['=', 'column_id', 0])
                    ->andWhere(['=', 'board_id', $activeBoard->id])
                    ->count();

                $backlogSize = $query
                    ->from(Ticket::tableName())
                    ->where(['=', 'column_id', 0])
                    ->andWhere(['=', 'board_id', $activeBoard->id])
                    ->count();

                $kanbanActive = $query
                    ->from(Ticket::tableName())
                    ->where(['>', 'updated_at', $frontPageTimespan])
                    ->andWhere(['>', 'column_id', 0])
                    ->andWhere(['=', 'board_id', $activeBoard->id])
                    ->count();

                $kanbanSize = $query
                    ->from(Ticket::tableName())
                    ->where(['>', 'column_id', 0])
                    ->andWhere(['=', 'board_id', $activeBoard->id])
                    ->count();

                $completedActive = $query
                    ->from(Ticket::tableName())
                    ->where(['>', 'updated_at', $frontPageTimespan])
                    ->andWhere(['<', 'column_id', 0])
                    ->andWhere(['=', 'board_id', $activeBoard->id])
                    ->count();

                $completedSize = $query
                    ->from(Ticket::tableName())
                    ->where(['<', 'column_id', 0])
                    ->andWhere(['=', 'board_id', $activeBoard->id])
                    ->count();

                $boardActivity['backlog'] = [
                    'updates' => $backlogActive,
                    'size' => $backlogSize,
                    'url' => '/board/backlog'
                ];

                $boardActivity['kanban'] = [
                    'updates' => $kanbanActive,
                    'size' => $kanbanSize,
                    'url' => '/board'
                ];

                $boardActivity['completed'] = [
                    'updates' => $completedActive,
                    'size' => $completedSize,
                    'url' => '/board/completed'
                ];

                $newTicketCount = isset(Yii::$app->params['newTicketCount']) ? Yii::$app->params['newTicketCount'] : 5;
                $newTickets = Ticket::find()
                    ->where(['>', 'updated_at', $frontPageTimespan])
                    ->andWhere(['=', 'board_id', $activeBoard->id])
                    ->orderBy(['updated_at' => SORT_DESC])
                    ->limit($newTicketCount)->all();

                $news = SiteNews::find()->orderBy(['updated_at' => SORT_DESC])->limit(10)->all();

                $tasks = Task::find()
                    ->where(['completed' => 0])
                    ->orderBy(['due_date' => SORT_ASC])
                    ->limit(5)
                    ->all();
            }

            return $this->render('index', [
                'boardActivity' => $boardActivity,
                'newTickets' => $newTickets,
                'news' => $news,
                'board' => $activeBoard,
                'tasks' => $tasks,
                'kanBanOverview' => $kanBanOverview,
            ]);
        }
    }

    /**
     * Retrieves all Boards and KanBanTickets for the current user
     */
    protected function getUserOverview()
    {
        $returnValue = [];
        $userBoardIds = Yii::$app->user->getIdentity()->board_id;
        $userBoards = Board::find()
            ->where(['id' => explode(',', $userBoardIds)])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        foreach ($userBoards as $userBoard) {
            $boardKanBanTickets = Ticket::find()
                ->where(['=', 'board_id', $userBoard->id])
                ->andWhere(['>', 'column_id', 0])
                ->orderBy(['title' => SORT_ASC])
                ->all();
            foreach ($boardKanBanTickets as $boardTicket) {
                $returnValue[$userBoard->title][] = $boardTicket->title;
            }
        }

        return $returnValue;
    }

    public function actionLogin() {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            if (YII_ENV_DEMO) {
                $session = Yii::$app->session;
                $session->setFlash('info',
                    'Login as a Demo User with <u>username</u>: <strong>demo</strong> and <u>password</u>: <strong>demo</strong>.');
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout() {

        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success',
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout() {

        return $this->render('about');
    }

    public function actionSignup() {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset() {

        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error',
                    'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}

