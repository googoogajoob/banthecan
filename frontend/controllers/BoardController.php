<?php

namespace frontend\controllers; //namespace must be the first statement

use common\models\Board;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Ticket;
use yii\filters\AccessControl;

class BoardController extends \yii\web\Controller {

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

        //initialize arrays, otherwise possible error in call to render, if they don't exist
        $ticketData = null;
        $columnData = null;

        $session = \Yii::$app->session;
        $currentBoard = $session->get('currentBoard');
        $board = Board::findOne($currentBoard);

        $columnRecords = $board->getBoardColumns()->where('id > 0')->orderBy('display_order, id')->all();
        foreach ($columnRecords as $singleColumnRecord) {
            $columnData[] = [
                'title' => $singleColumnRecord->title,
                'attribute' => $singleColumnRecord->id,
                'displayOrder' => $singleColumnRecord->display_order,
            ];

            $columnTickets = $singleColumnRecord->getTickets()->orderBy('column_id, ticket_order')->asArray()->all();
            foreach ($columnTickets as $singleColumnTicket) {
                $newTicketDataRecord = [
                    'title' => $singleColumnTicket['title'],
                    'id' => $singleColumnTicket['id'],
                    'description' => $singleColumnTicket['description'],
                    'created_by' => $singleColumnTicket['created_by'],
                    'assignedName' => User::findOne($singleColumnTicket['created_by'])->username,
                    'columnId' => $singleColumnTicket['column_id'],
                    'created_at' => $singleColumnTicket['created_at'],
                    'ticketOrder' => $singleColumnTicket['ticket_order'],
                ];

                $ticketData[]= $newTicketDataRecord;
            }
        }

        return $this->render('index', [
                'boardTitle' => $board->title,
                'boardDescription' => $board->description,
                'columnData' => $columnData ? $columnData : [],
                'ticketData' => $ticketData ? $ticketData : [],
            ]
        );
    }

    /**
     * Shows tickets in the Backlog
     */
    public function actionBacklog() {
        $board = Board::getActiveboard();

        return $this->render('backlog', [
            'tickets' => $board->getBacklog()->all(),
        ]);
    }

    /**
     * Shows completed tickets
     */
    public function actionCompleted() {
        $board = Board::getActiveboard();

        return $this->render('completed', [
            'tickets' => $board->getCompleted()->all(),
        ]);
    }

    /**
     * Allows the current user to select the active board from his/her board options
     */
    public function actionSelect() {
        $userBoardId = explode(',', User::findOne(\Yii::$app->getUser()->id)->board_id);

        $userBoards = new ActiveDataProvider([
            'query' => Board::find()->where(['id' => $userBoardId]),
        ]);
        $boardCount = $userBoards->getTotalCount();

        if ($boardCount == 0) {
            // No Boards, log user out
            \Yii::$app->user->logout();
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
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $activeBoardId = $request->get('id');
        $session->set('currentBoardId', $activeBoardId);
        $boardTitle = Board::findOne($activeBoardId)->title;
        $session->setFlash('success', "Board activated: $boardTitle");
        $this->goHome();
    }
}
