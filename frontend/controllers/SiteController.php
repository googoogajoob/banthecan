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
            $activeBoard = Board::getActiveBoard();
            $sevenDaysAgo = time() - 604800; //Seconds in 7 days 60*60*24*7 = 604800;
            $query = new Query;

            $activity['Backlog'] = $query
                ->from(Ticket::tableName())
                ->where(['>', 'updated_at', $sevenDaysAgo])
                ->where(['=', 'column_id', 0])
                ->where(['=', 'board_id', $activeBoard->id])
                ->count();
            $activity['Kanban'] = $query
                ->from(Ticket::tableName())
                ->where(['>', 'updated_at', $sevenDaysAgo])
                ->where(['>', 'column_id', 0])
                ->where(['=', 'board_id', $activeBoard->id])
                ->count();
            $activity['Completed'] = $query
                ->from(Ticket::tableName())
                ->where(['>', 'updated_at', $sevenDaysAgo])
                ->where(['<', 'column_id', 0])
                ->where(['=', 'board_id', $activeBoard->id])
                ->count();
/*            $activity['Task'] = $query
                ->from(Task::tableName())
                ->where(['>', 'updated_at', $sevenDaysAgo])->count();
            $activity['Resolution'] = $query
                ->from(Resolution::tableName())
                ->where(['>', 'updated_at', $sevenDaysAgo])->count();
*/

            $newTickets = Ticket::find()
                ->where(['>', 'updated_at', $sevenDaysAgo])
                ->where(['>=', 'column_id', 0])
                ->orderBy(['updated_at' => SORT_DESC])
                ->limit(5)
                ->all();

            $news = SiteNews::find()->orderBy(['updated_at' => SORT_DESC])->limit(10)->all();

            return $this->render('index', [
                'activity' => $activity,
                'news' => $news,
                'board' => $activeBoard,
                'newTickets' => $newTickets
            ]);
        }
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

