<?php

namespace common\models;

use common\models\Board;
use yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\Ticket;


/**
 * This is the model class for table "board_column".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $board_id
 * @property string  $title
 * @property integer $display_order
 * @property integer $receiver
 * @property Board $board
 * @property string  $ticket_column_configuration
 * @property Ticket[] $tickets
 */
class Column extends \yii\db\ActiveRecord
{
    // The receiver values should refer to the column IDs of the receiving columns
    // However, the IDs of the columns are first known when they are created
    // These values are therefore relative values, which will be used when creating the columns
    // to determine the actual ID.
    private static $demoColumns = [
        ['title' => 'Agenda',       'order' => 1, 'receiver' => '3'],
        ['title' => 'Waiting',      'order' => 2, 'receiver' => '3'],
        ['title' => 'Discussion',   'order' => 3, 'receiver' => '2,4'],
        ['title' => 'Action',       'order' => 4, 'receiver' => '2,5'],
        ['title' => 'Protocol',     'order' => 5, 'receiver' => '2'],
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'column';
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
            [['board_id', 'title'], 'required'],
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'board_id', 'display_order'], 'integer'],
            [['title','receiver'], 'string'],
            [['ticket_column_configuration'],
                'in',
                'range' => Yii::$app->ticketDecorationManager->getAvailableTicketDecorations(),
                'allowArray' => true],

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
            'board_id' => 'Board ID',
            'title' => 'Title',
            'display_order' => 'Display Order',
            'receiver' => 'Receiver',
            'ticket_column_configuration' => 'Ticket Column Configuration'
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            $this->ticket_column_configuration = serialize($this->ticket_column_configuration);

            return true;
        }

        return false;
    }

    public function afterFind() {
        parent::afterFind();
        $this->ticket_column_configuration = unserialize($this->ticket_column_configuration);
    }


    /**
     * @return \yii\db\ActiveRecord
     */
    public function getTickets()
    {
        Yii::$app->ticketDecorationManager
            ->registerDecorations($this->ticket_column_configuration);

        return $this->hasMany(Ticket::className(), ['column_id' => 'id', 'board_id' => 'board_id'])
                    ->orderBy('ticket_order')
                    ->all();
    }

    /**
     * Creates a set of Demo Columns
     *
     * The relative reference IDs between the columns must be set
     * to absolute IDs after the records have been saved since the (my)sql storage ID is not known
     * until the columns are saved in the DB.
     *
     * @return boolean
     */
    public function createDemoColumns($boardId) {

        if (YII_ENV_DEMO) {
            $this->deleteAll();

            $firstColumn = true;
            foreach (self::$demoColumns as $demoColumn) {
                $this->title = $demoColumn['title'];
                $this->display_order = $demoColumn['order'];
                $this->board_id = $boardId;

                $this->isNewRecord = true;
                $this->id = null;

                //Save initial column, the relative columns field is calculate below
                if (!$this->save()) {
                    return false;
                }

                if ($firstColumn) {
                    $firstColumnId = $this->id;
                    $firstColumn = false; //only execute tis if statement one time, the first time through the loop
                }

                $this->receiver = $this->convertRelativeIDtoActual($firstColumnId, $demoColumn['receiver']);
                if (!$this->save()) {
                    return false;
                }

            }

            // The Board must know what the entry column ID is
            $currentBoard = Board::findOne($boardId);
            $currentBoard->entry_column = $firstColumnId;
            $currentBoard->save();
        }

        return true;
    }

    /**
     * ToDo: At some point this may need to be refined.
     * There is no guarantee that the column will have successive IDs, although in the DEMO scenario
     * it will likely always be the case
     *
     */
    private function convertRelativeIDtoActual($firstColumnID, $receiverList) {
        $relativeList = explode(',', $receiverList);
        foreach($relativeList as $recieverID) {
            $returnList[] = $recieverID + $firstColumnID - 1;
        }

        return implode(',', $returnList);
    }

}
