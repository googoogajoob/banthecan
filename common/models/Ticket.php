<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $column_id
 *
 * @property BoardColumn $column
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * The status (column_id) of tickets in the backlog
     */
    const BACKLOG_STATUS = 0;

    /**
     * The default status (column_id) of tickets that are completed
     */
    const DEFAULT_COMPLETED_STATUS = -1;

    /**
     * The default status (column_id) of tickets that are on the kanban board
     */
    const DEFAULT_BOARD_STATUS = 1;

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
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'column_id'], 'required'],
            [['id', 'created_at', 'updated_at', 'user_id', 'column_id', 'ticket_order'], 'integer'],
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
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'column_id' => 'Column ID',
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
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Returns the status of a ticket, whether ot not it is currently active
     * on the KanBanBoard
     * @return Boolean true = backlog, false = not backlog
     */
    public function isBacklog() {
        return (bool)($this->getColumnId() == self::BACKLOG_STATUS);
    }

    /**
     * Returns the status of a ticket, whether ot not it is currently active
     * on the KanBanBoard
     * @return Boolean true = active, false = not active
     */
    public function isBoard() {
        return (bool)($this->getColumnId() >= self::DEFAULT_BOARD_STATUS);
    }

    /**
     * Returns the status of a ticket, whether ot not it is currently active
     * on the KanBanBoard
     * @return Boolean true = active, false = not active
     */
    public function isCompleted() {
        return (bool)($this->getColumnId() < self::DEFAULT_COMPLETED_STATUS);
    }

    /**
     * Sets the Status of the Ticket to be in the Backlog
     *
     * @return $this common\models\ticket
     */
    public function moveToBacklog() {
        $this->setColumnId(self::BACKLOG_STATUS);

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
     * Sets the Status of the Ticket to be on the Board, The Default Board column, start position is used
     *
     * @return $this common\models\ticket
     */
    public function moveToBoard() {
        $this->setColumnId(self::DEFAULT_BOARD_STATUS);

        return $this;
    }

    /**
     * Sets the Status of the Ticket to be in the Backlog
     *
     * @return $this common\models\ticket
     */
    public function moveToColumn() {
        $this->setColumnId(self::DEFAULT_BOARD_STATUS);

        /* Need to verify the column Limits*/

        return $this;
    }
}
