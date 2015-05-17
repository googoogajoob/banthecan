<?php

namespace common\models;

use yii;
use common\models\Ticket;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\web\NotFoundHttpException;


/**
 * This is the model class for table "board".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $title
 * @property string $description
 * @property integer $max_lanes
 *
 * @property BoardColumn[] $boardColumns
 */
class Board extends \yii\db\ActiveRecord {

    const NO_ACTIVE_BOARD_MESSAGE = 'An Active Board Has Been Set';
    const NO_ACTIVE_BOARD_STATUS_TEST = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {

        return 'board';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {

        return [
            [['title', 'description', 'max_lanes'], 'required'],
            [['id', 'created_at', 'created_by', 'updated_by', 'updated_at', 'max_lanes'], 'integer'],
            [['title', 'description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'description' => 'Description',
            'max_lanes' => 'Max Lanes',
        ];
    }

    /**
     * Returns the Kanban Columns associated with this board
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColumns() {

        return $this->hasMany(Column::className(), ['board_id' => 'id'])
            ->orderBy('display_order')
            ->all();
    }

    /**
     * Retrieves the current active board ID for this session
     * if not found an error is thrown
     * If found returns the board active record matching the ID
     *
     * @throws yii\web\NotFoundHttpException
     * @return \yii\db\ActiveRecord
     */
    public static function getActiveboard() {

        $session = Yii::$app->session;
        $currentBoardId = $session->get('currentBoardId');

        if ($currentBoardId == self::NO_ACTIVE_BOARD_STATUS_TEST) {
            throw new NotFoundHttpException(self::NO_ACTIVE_BOARD_MESSAGE);
        } else {
            Ticket::restrictQueryToBoard($currentBoardId);
            return self::findOne($currentBoardId);
        }
    }

}