<?php

namespace frontend\controllers;

use common\models\Board; //Interesting, I just discovered that the "use" must come after "namespace"

class KanbanboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $board = Board::findOne(1);
        $columnData = $board->getBoardColumns()->orderBy('id')->asArray()->all();
        foreach($columnData as $columnRecord) {
            $columnName[] = $columnRecord['name'];
        }

        return $this->render('index',[
            'boardTitle' => $board->title,
            'boardDescription' => $board->description,
            'columnName' => $columnName,
            ]
        );
    }
}
