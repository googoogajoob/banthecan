<?php

namespace frontend\controllers; //namespace must be the first statement

use yii;
use common\models\Board;
use common\models\Ticket;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\View;

class BoardController extends \yii\web\Controller {

    const DEFAULT_PAGE_SIZE = 24;
    const LONG_POLLING_TIMEOUT = 300000; // Milliseconds, used directly in JS,
    const LONG_POLLING_SLEEP = 1; // Seconds, server sleep interval during long polling
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
    public function beforeAction($action) {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($action->id == 'completed' or
            $action->id == 'backlog' or
            $action->id == 'index'
        ) {
            $this->currentBoard = Board::getActiveBoard();
        }

        return true; // or false to not run the action
    }

    /**
     * Default Action, shows active tickets in a KanBan Board
     */
    public function actionIndex()
    {
        $this->layout = 'main-full';
        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getUrl());

        $this->getView()->on(View::EVENT_END_PAGE, [$this, 'jsAsFunction']);

        return $this->render('index', [
            'board' => $this->currentBoard,
            'columnHtml' => $this->getColumnHtml(),
        ]);
    }

    public function jsAsFunction($event)
    {
        $event->sender->js[View::POS_HEAD] = ['var initializeBoard;'];
        $event->sender->js[View::POS_HEAD] = ['var longPollingTimeout = ' . self::LONG_POLLING_TIMEOUT . ';'];
        $event->sender->js[View::POS_READY] = array_merge(
            ['initializeBoard = function() {'],
            $event->sender->js[View::POS_READY],
            ['}'],
            ['initializeBoard();']
        );

        return true;
    }

    protected function getColumnHtml()
    {
        $columnHtml = '';
        foreach($this->currentBoard->getColumns() as $column) {
            $columnHtml .= $this->renderPartial('@frontend/views/board/partials/_column', ['column' => $column]);
        }

        return $columnHtml;
    }

    /**
     * Shows tickets in the Backlog
     */
    public function actionBacklog() {

        $currentPageSize = Yii::$app->request->post(
            'per-page',
            Yii::$app->request->get('per-page', self::DEFAULT_PAGE_SIZE)
        );

        $this->layout = 'left';
        $searchModel = Yii::createObject('common\models\TicketSearch');
        $searchModel->setSessionKey('B');

        $dataProvider = $searchModel->search(Yii::$app->request->post(), 0);
        $dataProvider->pagination->defaultPageSize = self::DEFAULT_PAGE_SIZE;
        $dataProvider->pagination->pageSizeLimit = [1, 500];
        $dataProvider->pagination->pageSize = $currentPageSize;
        $dataProvider->sort = $this->createSortObject();

        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getUrl());

        return $this->render('backlog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pageTitle' => $this->currentBoard->backlog_name,
            'action' => Yii::$app->request->getUrl(),
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

        $this->layout = 'left';
        $searchModel = Yii::createObject('common\models\TicketSearch');
        $searchModel->setSessionKey('C');

        $dataProvider = $searchModel->search(Yii::$app->request->post(), -1);
        $dataProvider->pagination->defaultPageSize = self::DEFAULT_PAGE_SIZE;
        $dataProvider->pagination->pageSizeLimit = [1, 500];
        $dataProvider->pagination->pageSize = $currentPageSize;
        $dataProvider->sort = $this->createSortObject();

        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getUrl());

        return $this->render('completed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pageTitle' => $this->currentBoard->completed_name,
            'action' => Yii::$app->request->getUrl(),
            'currentPageSize' => $currentPageSize,
        ]);
    }

    /**
     * Allows the current user to select the active board from his/her board options
     */
    public function actionSelect() {

        $currentUser = Yii::$app->user->getIdentity();
        $userBoards = explode(',', $currentUser->board_id);
        $userBoardRecords = Board::findAll($userBoards);
        $boardCount = count($userBoardRecords);

        if ($boardCount == 0) {
            // No Boards, log user out
            Yii::$app->user->logout();
            return $this->render('noBoard');

        } elseif ($boardCount == 1) {
            // The only available board is selected automatically
            $this->actionActivate($userBoards[0]);

        } else {
            // User must select which board to activate
            $dataProvider = new ActiveDataProvider([
                'query' => Board::find()->where(['id' => $userBoards]),
            ]);

            return $this->render('select', ['userBoards' => $dataProvider]);
        }
    }

    public function actionActivate($id)
    {
        Yii::$app->user->getIdentity()->activateBoard($id);
        $this->goHome();
    }

    public function actionPolling()
    {
        session_write_close(); // !!! Important, otherwise there is blocking among server sessions
        $request = Yii::$app->request;
        if ($request->isAjax) {

            $boardTimestamp = $request->post('boardTimestamp');
            $sendUpdate = false;
            $counter = 0;
            //compute counter limit to be the same the the javascript timeout
            $counterLimit = self::LONG_POLLING_TIMEOUT / 1000 /self::LONG_POLLING_SLEEP;

            while (!$sendUpdate && ($counter < $counterLimit)) {
                sleep(self::LONG_POLLING_SLEEP);
                $counter ++;
                $sendUpdate = Ticket::hasNewTicket($boardTimestamp);
            }

            if ($sendUpdate) {

                //$debugHtml = '<div class="alert alert-info"> Success: ' . $boardTimestamp . ' (' . $counter .')</div>';

                $this->currentBoard = Board::getActiveBoard();
                $successHtml = $this->getColumnHtml();

                Yii::$app->response->format = 'json';

                return [
                    //'html' => $debugHtml . $successHtml,
                    'html' => $successHtml,
                    'boardTimestamp' => $boardTimestamp,
                    'newTimestamp' => time(),
                    'count' => $counter
                ];
            }
        }
    }

    /**
     * Creates the sort Object Needed for Backlog and Completed Listings
     * @return yii\data\Sort
     */
    protected function createSortObject() {

        $sort = new Sort([
            'attributes' => [
                'vote_priority' => [
                    'label' => \Yii::t('app', 'Priority')
                ],
                'title' => [
                    'label' => \Yii::t('app', 'Title')
                ],
                'created_at' => [
                    'label' => \Yii::t('app', 'Created')
                ],
            ],
            'defaultOrder' => [
                'vote_priority' => SORT_DESC,
                'title' => SORT_ASC,
            ]
        ]);

        return $sort;
    }
}
