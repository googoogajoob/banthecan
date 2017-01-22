<?php

namespace common\models;

use yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "board_column".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $board_id
 * @property string $title
 * @property integer $display_order
 * @property integer $receiver
 * @property Board $board
 * @property string $ticket_column_configuration
 * @property Ticket[] $tickets
 */
class Column extends ActiveRecord
{

    public $receiverArray = [];

    // The receiver values should refer to the column IDs of the receiving columns
    // However, the IDs of the columns are first known when they are created
    // These values are therefore relative values, which will be used when creating the columns
    // to determine the actual ID.
    private static $demoColumns = [
        ['title' => 'Agenda', 'order' => 1, 'receiver' => '3'],
        ['title' => 'Waiting', 'order' => 2, 'receiver' => '3'],
        ['title' => 'Discussion', 'order' => 3, 'receiver' => '2,4'],
        ['title' => 'Action', 'order' => 4, 'receiver' => '2,5'],
        ['title' => 'Protocol', 'order' => 5, 'receiver' => '2'],
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
            [['title', 'receiver'], 'string'],
            [['receiverArray'], 'safe'],
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
    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            $this->ticket_column_configuration = serialize($this->ticket_column_configuration);
            $this->receiver = implode(',', $this->receiverArray);

            return true;
        }

        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->ticket_column_configuration = unserialize($this->ticket_column_configuration);
        $this->receiverArray = explode(',', $this->receiver);

        if (!is_array($this->ticket_column_configuration)) {
            $this->ticket_column_configuration = [];
        }

    }

    /**
     * @return \yii\db\ActiveRecord
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['column_id' => 'id', 'board_id' => 'board_id'])
            ->orderBy('ticket_order')
            ->all();
    }

    /**
     * @return \yii\db\ActiveRecord
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    public function getBoardTitle()
    {
        $board = $this->getBoard()->one();

        return $board->title;
    }

    public function getReceiverList()
    {
        if ($this->receiver == '') {
            return '';
        } else {
            $receivingColumnIDs = explode(',', $this->receiver);

            $receivingColumns = Column::find()->where(['id' => $receivingColumnIDs])->orderBy('display_order')->asArray()->all();
            $receivingColumnTitles = ArrayHelper::map($receivingColumns, 'id', 'title');

            return implode(', ', $receivingColumnTitles);
        }
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
    public function createDemoColumns($boardId)
    {

        if (YII_ENV_DEMO) {
            $this->deleteAll();

            $decorationClasses = Yii::$app->ticketDecorationManager->getAvailableTicketDecorations();

            $firstColumn = true;
            foreach (self::$demoColumns as $demoColumn) {
                $this->title = $demoColumn['title'];
                $this->display_order = $demoColumn['order'];
                $this->board_id = $boardId;

                $this->isNewRecord = true;
                $this->id = null;

                $this->ticket_column_configuration = [
                    $decorationClasses[0],
                    $decorationClasses[2],
                    $decorationClasses[3],
                    $decorationClasses[4],
                ];

                //Save initial column, the relative columns field is calculate below
                if (!$this->save()) {
                    return false;
                }

                if ($firstColumn) {
                    $firstColumnId = $this->id;
                    $firstColumn = false; //only execute this if statement one time, the first time through the loop
                }

                $this->receiver = $this->convertRelativeIDtoActual($firstColumnId, $demoColumn['receiver']);
                if (!$this->save(false, ['receiver'])) {
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
    private function convertRelativeIDtoActual($firstColumnID, $receiverList)
    {
        $relativeList = explode(',', $receiverList);
        foreach ($relativeList as $receiverID) {
            $returnList[] = $receiverID + $firstColumnID - 1;
        }

        return implode(',', $returnList);
    }

}
