<?php

namespace frontend\controllers; //namespace must be the first statement

use yii;
use common\models\Board;
use common\models\TicketSearch;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;


class BoardController extends \yii\web\Controller {

    const BOARD_NOT_FOUND = 'Active Board Not Found';
    const DEFAULT_PAGE_SIZE = 18;

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        ];
    }

    /**
     * Default Action, shows active tickets in a KanBan Board
     */
    public function actionIndex() {
        if (!$board = Board::getActiveboard()) {
            throw new NotFoundHttpException(self::BOARD_NOT_FOUND);
        }

        return $this->render('index', [
            'board' => $board,
        ]);
    }

    /**
     * Shows tickets in the Backlog
     */
    public function actionBacklog() {
        if (!$board = Board::getActiveboard()) {
            throw new NotFoundHttpException(self::BOARD_NOT_FOUND);
        }

        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere($searchModel->getBacklogQueryCondition());
        $dataProvider->pagination->pageSize = self::DEFAULT_PAGE_SIZE;

        return $this->render('backlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Shows completed tickets
     */
    public function actionCompleted() {
        if (!$board = Board::getActiveboard()) {
            throw new NotFoundHttpException(self::BOARD_NOT_FOUND);
        }

        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere($searchModel->getCompletedQueryCondition());
        $dataProvider->pagination->pageSize = self::DEFAULT_PAGE_SIZE;

        return $this->render('completed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Allows the current user to select the active board from his/her board options
     */
    public function actionSelect() {
        $userBoardId = explode(',', User::findOne(Yii::$app->getUser()->id)->board_id);

        $userBoards = new ActiveDataProvider([
            'query' => Board::find()->where(['id' => $userBoardId]),
        ]);
        $boardCount = $userBoards->getTotalCount();

        if ($boardCount == 0) {
            // No Boards, log user out
            Yii::$app->user->logout();
            return $this->render('noBoard');
        } elseif ($boardCount == 1) {
            // Only one board for user, activate it automatically
            $activeBoardId = $userBoards->getModels()[0]->id;
            $this->redirect(['activate','id' => $activeBoardId]);
        } else {
            // USer must select which board to activate
            return $this->render('select',['userBoards' => $userBoards]);
        }
    }

    /**
     * Activates the Board for the current User. This means the selected board is made
     * available globally via cookies and(or) sessions
     */
    public function actionActivate() {
        $session = Yii::$app->session;
        $request = Yii::$app->request;
        $activeBoardId = $request->get('id');
        $session->set('currentBoardId', $activeBoardId);
        $boardTitle = Board::findOne($activeBoardId)->title;
        $session->setFlash('success', "Board activated: $boardTitle");
        Yii::$app->params['title'] = $boardTitle;
        $this->goHome();
    }
}
