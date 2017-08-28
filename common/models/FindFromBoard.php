<?php

namespace common\models;

use \yii\db\ActiveRecord;

class FindFromBoard extends ActiveRecord
{
    /**
     * If specific conditions are stipulated via the Query Object the standard find() method
     * is adapted and the additional query conditions are applied.
     *
     * @inheritdoc
     */
    public static function find($query = null)
    {
        if (!$query) {
            $query = parent::find();
        }

        $currentActiveBoard = Board::getCurrentActiveBoard();
        if ($currentActiveBoard) {
            $query->andWhere(['board_id' => $currentActiveBoard->id]);
        }

        return $query;
    }
}
