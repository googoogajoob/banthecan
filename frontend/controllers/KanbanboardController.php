<?php

namespace frontend\controllers; //namespace must be the first statement

use yii;
use common\models\Board;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Ticket;
use yii\filters\AccessControl;

class KanbanboardController extends \yii\web\Controller {

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

    public function actionIndex() {

        //initialize arrays, otherwise possible error in call to render, if they don't exist
        $ticketData = null;
        $columnData = null;

        $userBoard = User::findIdentity(Yii::$app->getUser()->id)->board_id;
        $board = Board::findOne($userBoard);

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
                    'user_id' => $singleColumnTicket['user_id'],
                    'assignedName' => User::findOne($singleColumnTicket['user_id'])->username,
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

    public function actionBacklog() {
        $tickets = ticket::findBacklog();

        return $this->render('backlog', [
            'tickets' => $tickets,
        ]);
    }

    public function actionCompleted() {
        $tickets = ticket::findCompleted();

        return $this->render('completed', [
            'tickets' => $tickets,
        ]);
    }

    public function actionSelect() {
        $userBoardId = explode(',', User::findOne(Yii::$app->getUser()->id)->board_id);

        $userBoards = new ActiveDataProvider([
            'query' => Board::find()->where(['id' => $userBoardId]),
        ]);

        return $this->render('select',['userBoards' => $userBoards]);
    }
}
