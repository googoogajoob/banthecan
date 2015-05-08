<?php

namespace common\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $title
 * @property string $description
 * @property integer $column_id
 * @property integer $board_id
 *
 * @property BoardColumn $column
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * The status (column_id) of tickets in the backlog
     */
    const DEFAULT_BACKLOG_STATUS = 0;

    /**
     * Alternate status (column_id) of tickets in the backlog
     * Tis is needed when using a mysql foreign Key Constraint on the tickets. On DELETE of the column the
     * column ID of the ticket is set back to null (0 is not feasible, no default value)
     */
    const ALTERNATE_BACKLOG_STATUS = null;

    /**
     * The default status (column_id) of tickets that are completed
     */
    const DEFAULT_COMPLETED_STATUS = -1;

    /**
     * The default status (column_id) of tickets that are on the kanban board
     */
    const DEFAULT_KANBANBOARD_STATUS = 1;

    /**
     * Error Message when assigning ticket to current active board
     */
    const ACTIVE_BOARD_NOT_FOUND = 'Current Active Board Not Found';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'column_id'], 'required'],
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'column_id', 'ticket_order'], 'integer'],
            [['title', 'description'], 'string'],
            [['id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'title' => 'Title',
            'description' => 'Description',
            'column_id' => 'Column ID',
            'board_id' => 'Board ID',
            'ticket_order' => 'Ticket Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumn()
    {
        return $this->hasOne(BoardColumn::className(), ['id' => 'column_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Returns the status of a ticket, whether ot not it is currently active
     * on the KanBanBoard
     * @return Boolean true = backlog, false = not backlog
     */
    public function isBacklog() {
        return (bool)($this->getColumnId() == self::DEFAULT_BACKLOG_STATUS or
                      $this->getColumnId() == self::ALTERNATE_BACKLOG_STATUS);
    }

    /**
     * Returns the status of a ticket, whether ot not it is currently active
     * on the KanBanBoard
     * @return Boolean true = active, false = not active
     */
    public function isKanBanBoard() {
        return (bool)($this->getColumnId() >= self::DEFAULT_KANBANBOARD_STATUS);
    }

    /**
     * Returns the status of a ticket, whether ot not it is currently active
     * on the KanBanBoard
     * @return Boolean true = active, false = not active
     */
    public function isCompleted() {
        return (bool)($this->getColumnId() <= self::DEFAULT_COMPLETED_STATUS);
    }

    /**
     * Sets the Status of the Ticket to be in the Backlog
     *
     * @return $this common\models\ticket
     */
    public function moveToBacklog() {
        $this->setColumnId(self::DEFAULT_BACKLOG_STATUS);

        return $this;
    }

    /**
     * Sets the Status of the Ticket to be completed.
     *
     * @param integer New completed status, defaults to self::DEFAULT_COMPLETED_STATUS
     *                completed status can be any negative number. If the new status
     *                is not negative (i.e. not a completed status),
     *                then the default completed status is used)
     * @return $this common\models\ticket
     */
    public function moveToCompleted($newTicketStatus = self::DEFAULT_COMPLETED_STATUS) {
        if ($newTicketStatus <= self::DEFAULT_COMPLETED_STATUS){
            $this->setColumnId($newTicketStatus);
        } else {
            $this->setColumnId(self::DEFAULT_COMPLETED_STATUS);
        }

        return $this;
    }

    /**
     * Sets the Status of the Ticket to be on the Kanban Board, The Default Board column,start position is used
     *
     * @return $this common\models\ticket
     */
    public function moveToKanBanBoard() {
        $this->setColumnId(self::DEFAULT_KANBANBOARD_STATUS);

        return $this;
    }

    /**
     * Sets the Status of the Ticket to be in the Backlog
     *
     * @return $this common\models\ticket
     */
    public function moveToColumn($newTicketStatus = self::DEFAULT_KANBANBOARD_STATUS) {
        $this->setColumnId($newTicketStatus);

        return $this;
    }

    /**
     * Sets the Current Board iof the Ticket to be the active current board
     * @throws NotFoundHttpException
     * @return $this common\models\ticket
     */
    public function setToCurrentActiveBoard() {
        $session = Yii::$app->session;
        $newBoardId = $session->get('currentBoardId');
        if ($newBoardId) {
            //everything is OK, current Board exists for this session
            $this->board_id = $newBoardId;
        } else {
            //This should not occur, but just in case
            throw new NotFoundHttpException(self::ACTIVE_BOARD_NOT_FOUND);
        }
    }

    /**
     * Finds all Backlog Tickets
     *
     * @return array|ActiveRecord[] the query results.
     */
    public function findBacklog() {
        $session = \Yii::$app->session;
        $currentBoard = $session->get('currentBoard');

        return Ticket::find()
            ->where(['column_id' => 0])
            ->orWhere(['column_id' => null])
            ->andWhere(['board_id' => $currentBoard])
            ->asArray()
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();
    }

    /**
     * Finds all Completed Tickets
     *
     * @return array|ActiveRecord[] the query results.
     */
    public function findCompleted() {
        $session = \Yii::$app->session;
        $currentBoard = $session->get('currentBoard');

        return Ticket::find()
            ->where(['<', 'column_id', 0])
            ->andWhere(['board_id' => $currentBoard])
            ->asArray()
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();
    }
}
