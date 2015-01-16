<?php

namespace frontend\controllers;

use common\models\Board; //Interesting, I just discovered that the "use" must come after "namespace"
use common\models\User;

class KanbanboardController extends \yii\web\Controller {

    public function actionIndex() {

        $board = Board::findOne(1);
        // TODO: $id needs to be changed to a predefined or user defined ordering
        $columnRecords = $board->getBoardColumns()->orderBy('id')->all();
        foreach ($columnRecords as $singleColumnRecord) {
            $columnData[] = [
                'title' => $singleColumnRecord->title,
                'attribute' => $singleColumnRecord->id,
            ];

            $columnTickets = $singleColumnRecord->getTickets()->orderBy('id')->asArray()->all();
            foreach ($columnTickets as $singleColumnTicket) {
                $ticketData[$singleColumnRecord['id']] = [
                    'title' => $singleColumnTicket['title'],
                    'description' => $singleColumnTicket['description'],
                    'assignedId' => $singleColumnTicket['user_id'],
                    'assignedName' => User::findOne($singleColumnTicket['user_id'])->username,
                ];
            }
        }

        return $this->render('index', [
                'boardTitle' => $board->title,
                'boardDescription' => $board->description,
                'columnData' => $columnData,
                'ticketData' => $ticketData,
            ]
        );
    }
}
