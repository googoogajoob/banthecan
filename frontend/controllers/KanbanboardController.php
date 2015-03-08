<?php

namespace frontend\controllers; //namespace must be the first statement

use common\models\Board; //Interesting, I just discovered that the "use" must come after "namespace"
use common\models\User;

class KanbanboardController extends \yii\web\Controller {

    public function actionIndex() {

        //initialize arrays, otherwise possible error in call to render, if they don't exist
        $ticketData = null;
        $columnData = null;

        $board = Board::findOne(1);
        // TODO: $id needs to be changed to a predefined or user defined ordering
        $columnRecords = $board->getBoardColumns()->where('id > 0')->orderBy('id')->all();
        foreach ($columnRecords as $singleColumnRecord) {
            $columnData[] = [
                'title' => $singleColumnRecord->title,
                'attribute' => $singleColumnRecord->id,
            ];

            $columnTickets = $singleColumnRecord->getTickets()->orderBy('column_id, ticket_order')->asArray()->all();
            foreach ($columnTickets as $singleColumnTicket) {
                $newTicketDataRecord = [
                    'title' => $singleColumnTicket['title'],
                    'ticketId' => $singleColumnTicket['id'],
                    'description' => $singleColumnTicket['description'],
                    'assignedId' => $singleColumnTicket['user_id'],
                    'assignedName' => User::findOne($singleColumnTicket['user_id'])->username,
                    'columnId' => $singleColumnTicket['column_id'],
                    'created' => $singleColumnTicket['created_at'],
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
}
