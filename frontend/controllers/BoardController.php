<?php

namespace frontend\controllers; //namespace must be the first statement

use yii;
use common\models\Board;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class BoardController extends \yii\web\Controller {

    const DEFAULT_PAGE_SIZE = 24;
    private $currentBoard = null;

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
     * Initialize the Board to the Current Board_id, and implicitly
     * restrict all ticket queries to members of this board for
     * the actions: completed, backlog and index
     *
     * @param yii\base\Action $action
     * @return bool
     * @throws yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($action->id == 'completed' or
            $action->id == 'backlog' or
            $action->id == 'index') {
            $this->currentBoard = Board::getActiveBoard();
        }

        return true; // or false to not run the action
    }
    /**
     * Default Action, shows active tickets in a KanBan Board
     */
    public function actionIndex()
    {
        $this->layout = 'right';
        Yii::$app->getUser()->setReturnUrl('/board/index');

        return $this->render('index', [
            'board' => $this->currentBoard,
        ]);
    }

    /**
     * Shows tickets in the Backlog
     */
    public function actionBacklog() {

        $currentPageSize = Yii::$app->request->post(
            'per-page',
            Yii::$app->request->get('per-page', self::DEFAULT_PAGE_SIZE)
        );

        $this->layout = 'left-right';
        $searchModel = Yii::createObject('common\models\TicketSearch');

        Yii::$app->ticketDecorationManager
                 ->registerDecorations($this->currentBoard->ticket_backlog_configuration);

        $dataProvider = $searchModel->search(Yii::$app->request->get(), 0);
        $dataProvider->pagination->defaultPageSize = self::DEFAULT_PAGE_SIZE;
        $dataProvider->pagination->pageSizeLimit = [1, 500];
        $dataProvider->pagination->pageSize = $currentPageSize;
        $dataProvider->sort = $this->createSortObject();

        Yii::$app->getUser()->setReturnUrl('/board/backlog');

        return $this->render('backlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pageTitle' => $this->currentBoard->backlog_name,
            'action' => $this->action->id,
            'currentPageSize' => $currentPageSize,
        ]);
    }

    /**
     * Shows completed tickets
     */
    public function actionCompleted() {

        $currentPageSize = Yii::$app->request->post(
            'per-page',
            Yii::$app->request->get('per-page', self::DEFAULT_PAGE_SIZE)
        );

        $this->layout = 'left-right';
        $searchModel = Yii::createObject('common\models\TicketSearch');

        Yii::$app->ticketDecorationManager
                 ->registerDecorations($this->currentBoard->ticket_completed_configuration);

        $dataProvider = $searchModel->search(Yii::$app->request->get(), -1);
        $dataProvider->pagination->defaultPageSize = self::DEFAULT_PAGE_SIZE;
        $dataProvider->pagination->pageSizeLimit = [1, 500];
        $dataProvider->pagination->pageSize = $currentPageSize;
        $dataProvider->sort = $this->createSortObject();

        Yii::$app->getUser()->setReturnUrl('/board/completed');

        return $this->render('completed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pageTitle' => $this->currentBoard->completed_name,
            'action' => $this->action->id,
            'currentPageSize' => $currentPageSize,
        ]);
    }

    /**
     * Allows the current user to select the active board from his/her board options
     */
    public function actionSelect()
    {
        $currentUser = Yii::$app->user->getIdentity();
        $userBoards = explode(',', $currentUser->board_id);
        $userBoardRecords = Board::findAll($userBoards);
        $boardCount = count($userBoardRecords);

        if ($boardCount == 0) {
            // No Boards, log user out
            Yii::$app->user->logout();
            return $this->render('noBoard');

        } elseif ($boardCount == 1) {
            // Board should already be selected
            $currentUser->setActiveBoard($userBoards);
            Board::getActiveBoard();
            $this->goHome();

        } else {
            // User must select which board to activate
            $dataProvider = new ActiveDataProvider([
                'query' => Board::find()->where(['id' => $userBoards]),
            ]);

            return $this->render('select',['userBoards' => $dataProvider]);
        }
    }

    /**
     *
     */
    public function actionActivate($id)
    {
        $currentUser = Yii::$app->user->getIdentity();
        $currentUser->deactivateAllBoards();
        $currentUser->setActiveBoard([$id]);
        //Board::getActiveBoard();
        $this->goHome();
    }

    /**
     * Creates the sort Object Needed for Backlog and Completed Listings
     * @return yii\data\Sort
     */
    protected function createSortObject()
    {
        $sort = new Sort([
            'attributes' => [
                'title',
                'created_at' => [
                    'label' => 'Created'
                ],
                /*'updated_at' => [
                    'label' => 'Updated'
                ],*/
            ],
            'defaultOrder' => [
                'created_at' => SORT_DESC,
                'title' => SORT_ASC,
            ]
        ]);

        return $sort;
    }
}
