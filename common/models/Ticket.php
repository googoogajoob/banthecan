<?php

namespace common\models;

use dosamigos\taggable\Taggable;
use Faker\Factory;
use yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use frontend\models\blameTrait;
use yii\db\ActiveRecord;
use common\models\ticketDecoration\TicketDecorationLink;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string  $title
 * @property string  $description
 * @property integer $column_id
 * @property integer $board_id
 * @property integer $ticket_order
 * @property BoardColumn $column
 * @property string  $tagNames
 * @property string  $protocol
 * @property integer $vote_priority
 * @property string  $decoration_data
 *
 */
class Ticket extends ActiveRecord
{
	use blameTrait;

	const TICKET_TAG_MM_TABLE = 'ticket_tag_mm';
	const DEMO_BACKLOG_TICKETS = 100;
	const DEMO_BOARD_TICKETS = 5;
	const DEMO_COMPLETED_TICKETS = 50;

	/**
	 * The status (column_id) of tickets in the backlog
	 */
	const DEFAULT_BACKLOG_STATUS = 0;

	/**
	 * Alternate status (column_id) of tickets in the backlog
	 * This is needed when using a mysql foreign Key Constraint on the tickets. On DELETE of the column the
	 * column ID of the ticket is set back to null (0 is not feasible, no default value)
	 */
	const ALTERNATE_BACKLOG_STATUS = null;

	/**
	 * The default status (column_id) of tickets that are completed
	 */
	const DEFAULT_COMPLETED_STATUS = -1;

	/**
	 * Error Message when assigning ticket to current active board
	 */
	const ACTIVE_BOARD_NOT_FOUND = 'Current Active Board Not Found';

	/**
	 * If this variable is (> 0) all queries obtained through the find() function
	 * will be restricted to this value, i.e. (board_id = self::$restrictQueryToBoardId)
	 * Subsequent query modifications must use the and where (and related) methods in order to
	 * preserve this restriction. Subsequent use of a standard where() query will eliminate
	 * this restriction.
	 *
	 * This variable is set automatically from the board model
	 *
	 * @var int
	 */
	public static $restrictQueryToBoardId = 0;

	/*
	 * Used in conditions to test for a restrictedQuery based on board_Id
	 * The value of this constant should be a value that a board_Id cannot have
	 */
	const NO_BOARD_QUERY_RESTRICTION = 0;

    private $_decorationCount = 0;

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
		    Taggable::className(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
            [['title', 'column_id'], 'required'],
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'column_id', 'ticket_order', 'vote_priority'], 'integer'],
            [['title', 'description', 'protocol'], 'string'],
            [['id'], 'unique'],
            [['tagNames', 'decoration_data'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
            'id' => \Yii::t('app', 'ID'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'created_by' => \Yii::t('app', 'Created By'),
            'updated_by' => \Yii::t('app', 'Updated By'),
            'title' => \Yii::t('app', 'Title'),
            'description' => \Yii::t('app', 'Description'),
            'column_id' => \Yii::t('app', 'Column ID'),
            'board_id' => \Yii::t('app', 'Board ID'),
            'ticket_order' => \Yii::t('app', 'Ticket Order'),
            'tagNames' => \Yii::t('app', 'Tags'),
			'protocol' => \Yii::t('app', 'Protocol'),
			'vote_priority' => \Yii::t('app', 'Priority'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getColumn() {
		return $this->hasOne(Column::className(), ['id' => 'column_id'])->one();
	}

	/**
	 * @return \yii\db\ActiveRecord
	 */
	public function getUpdateUser() {
		return User::findOne($this->updated_by);
	}

	/**
	 * @return \yii\db\ActiveRecord
	 */
	public function getCreateUser() {
		return User::findOne($this->created_by);
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
	 * Returns the status of a ticket, whether or not it is currently active
	 * on the KanBanBoard
	 * @return Boolean true = active, false = not active
	 */
	public function isKanBanBoard() {
		// If the ticket is not in the Backlog or Completed Log, then it must be in the board
		return (bool)(      $this->getColumnId() != self::DEFAULT_BACKLOG_STATUS
		and   $this->getColumnId() != self::DEFAULT_COMPLETED_STATUS);
	}

	/**
	 * Returns the status of a ticket, whether or not it is currently active
	 * on the KanBanBoard
	 * @return Boolean true = active, false = not active
	 */
	public function isCompleted()
    {
		return (bool)($this->getColumnId() <= self::DEFAULT_COMPLETED_STATUS);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTags()
	{
		return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable(self::TICKET_TAG_MM_TABLE, ['ticket_id' => 'id']);
	}

	/**
	 * Increment the vote_priority
	 *
	 * @return $this common\models\ticket
	 */
	public function incrementVotePriority() {
		if ($this->vote_priority === null) {
			$this->vote_priority = 1;
		} else {
			$this->vote_priority++;
		}

		return $this;
	}

	/**
	 * Decrement the vote_priority
	 *
	 * @return $this common\models\ticket
	 */
	public function decrementVotePriority()
    {
		if ($this->vote_priority === null) {
			$this->vote_priority = -1;
		} else {
			$this->vote_priority--;
		}

		return $this;
	}

	/**
	 * Sets the Status of the Ticket to be in the Backlog
	 *
	 * @return $this common\models\ticket
	 */
	public function moveToBacklog()
    {
		$this->column_id = self::DEFAULT_BACKLOG_STATUS;

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
	public function moveToCompleted($newTicketStatus = self::DEFAULT_COMPLETED_STATUS)
    {
		if ($newTicketStatus <= self::DEFAULT_COMPLETED_STATUS){
			$this->column_id = $newTicketStatus;
		} else {
			$this->column_id = self::DEFAULT_COMPLETED_STATUS;
		}

		return $this;
	}

	/**
	 * Sets the Status of the Ticket to be on the Kanban Board,
	 * The Active Board,default start column is used
	 *
	 * @return $this common\models\ticket
	 */
	public function moveToKanBanBoard()
    {
		$this->column_id = Board::getActiveBoard()->entry_column;

		return $this;
	}

	/**
	 * Sets the Status of the Ticket to be in the Backlog
	 *
	 * @return $this common\models\ticket
	 */
	public function moveToColumn($newTicketStatus)
    {
		$this->column_id = $newTicketStatus;

		return $this;
	}

	/**
	 * Query to find all Backlog Tickets
	 *

	 * @return yii\db\QueryInterface
	 */
	public static function findBacklog()
    {
		return Ticket::find(parent::find()->where(['column_id' => 0])->orWhere(['column_id' => null]));
	}

	/**
	 * Query to find all Completed Tickets
	 *
	 * @return yii\db\QueryInterface
	 */
	public static function findCompleted()
    {
		return Ticket::find(parent::find()->where(['<', 'column_id', 0]));
	}

	/**
	 * Query to find one new ticket, which is in the KanBan and newer than the timestamp parameter
	 *
     * @return boolean
     */
	public static function hasNewTicket($timestamp)
	{
		$query = Ticket::find(parent::find()
			->where(['>', 'column_id', 0])
			->andWhere(['>', 'updated_at', $timestamp])
            ->limit(1)
		);

        $count = $query->count();

        return (bool)$count;
	}

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
		if (self::$restrictQueryToBoardId != self::NO_BOARD_QUERY_RESTRICTION) {
			return $query->andWhere(['board_id' => self::$restrictQueryToBoardId]);
		} else {
			return $query;
		}
	}

	public function afterFind()
    {
		parent::afterFind();
		// Force attribute to be an integer
		$this->column_id = intval($this->column_id);
        $this->decoration_data = unserialize($this->decoration_data);
        if (!is_array($this->decoration_data)) {
            $this->decoration_data = [];
        }
        $decorations = Yii::$app->ticketDecorationManager->getActiveTicketDecorations($this->column_id);
		if ($decorations) {
			$this->_decorationCount = count($decorations);
			$this->attachBehaviors($decorations);
		}
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            $this->decoration_data = serialize($this->decoration_data);

            return true;
        }

        return false;
    }

    public function hasDecorations()
    {
        return (bool) $this->_decorationCount > 0;
    }

	public function getDecorations()
    {
        $decorations = [];
        foreach ($this->getBehaviors() as $behavior) {
            if ($behavior instanceof TicketDecorationLink) {
                $decorations[] = $behavior;
            }
        }

        return $decorations;
    }

    public function setDecorationData($newDecorationData) {
        $this->decoration_data = $newDecorationData;
    }

    public function getDecorationData() {
        return $this->decoration_data;
    }

	/**
	 * Retrieves the Current Active Board Id for this session and sets the
	 * Ticket Class Variable self::$restrictQueryToBoardId to its value.
	 * This causes all ticket queries to be restricted to the current BoardId
	 * @param $currentBoardId Integer, Id to which all ticket queries will be restricted to
	 */
	public static function restrictQueryToBoard($currentBoardId)
    {
		Yii::trace("Restrict Query To Board ($currentBoardId)",'APC');
		self::$restrictQueryToBoardId = $currentBoardId;
	}

	/**
	 * Retrieves the Current Active Board Id for this session and sets the
	 * Ticket Class Variable self::$restrictQueryToBoardId to its value.
	 * This causes all ticket queries to be restricted to the current BoardId
	 */
	public static function clearBoardQueryRestriction()
    {
		self::$restrictQueryToBoardId = self::NO_BOARD_QUERY_RESTRICTION;
	}

	/**
	 * Creates a set of Demo Tickets
	 *
	 * @return boolean
	 */
	public function createDemoTickets($boardId)
    {
		if (YII_ENV_DEMO) {

			$this->deleteAll();
			Tags::deleteAllDemoTags();

			$faker = Factory::create();

			$tagPool = [];
			for ($i=0; $i<10; $i++){
				$tagPool[] = 'Tag' . substr($faker->text(5), 0, -1); // eliminate '.' at end
			}
			// Array Unique preserves Keys, I don't want them preserved
			$tagPool = explode(',', implode(',', array_unique($tagPool)));

			// Create Backlog Tickets
			for ($i = 0; $i < self::DEMO_BACKLOG_TICKETS; $i++) {
				$this->title = $faker->text(30);
				$this->description = $faker->text();
				$this->column_id = self::DEFAULT_BACKLOG_STATUS;
				$this->board_id = $boardId;
				$this->ticket_order = 0;
				$this->isNewRecord = true;
				$this->id = null;
				$this->tagNames = $this->getRandomDemoTags($tagPool);
				if (!$this->save()) {
					return false;
				}

				$this->created_at -= rand(0, 2600000); //random creation ca.in the previous 4 weeks
				if (!$this->save('false', ['created_at'])) {
					return false;
				}

			}

			// Create Completed Tickets
			for ($i = 0; $i < self::DEMO_COMPLETED_TICKETS; $i++) {
				$this->title = $faker->text(30);
				$this->description = $faker->text();
				$this->column_id = self::DEFAULT_COMPLETED_STATUS;
				$this->board_id = $boardId;
				$this->ticket_order = 0;
				$this->isNewRecord = true;
				$this->id = null;
				$this->tagNames = $this->getRandomDemoTags($tagPool);
				if (!$this->save()) {
					return false;
				}

				$this->created_at -= rand(0, 2600000); //random creation ca.in the previous 4 weeks
				if (!$this->save('false', ['created_at'])) {
					return false;
				}

			}

			// Create KanBanBoard Tickets
			for ($i = 0; $i < self::DEMO_BOARD_TICKETS; $i++) {
				$this->title = $faker->text(30);
				$this->description = $faker->text();
				$this->column_id = Board::findOne($boardId)->entry_column;
				$this->board_id = $boardId;
				$this->ticket_order = $i;
				$this->isNewRecord = true;
				$this->id = null;
				$this->tagNames = $this->getRandomDemoTags($tagPool);
				if (!$this->save()) {
					return false;
				}

				$this->created_at -= rand(0, 2600000); //random creation ca.in the previous 4 weeks
				if (!$this->save('false', ['created_at'])) {
					return false;
				}

			}
		}

		return true;
	}

	private function getRandomDemoTags($tagPool)
    {
		$tagPoolCount = count($tagPool);

		$tagPercentage = rand(1, 100);
		$assignTag = $tagPercentage > 65 ? 1 : 0; // percentage change of tags being assigned
		$returnList = '';

		if ($assignTag) {
			// Now determine which tags from the Pool should be assigned
			$isFirst = true;
			for($i=0; $i<$tagPoolCount; $i++) {
				$binaryUse = rand(0, 1); // zero or one, determines if this tag from the pool is used
				if ($binaryUse) {
					$preComma = $isFirst ? '' : ',';
					$returnList .= $preComma . $tagPool[$i];
					$isFirst = false;
				}
			}
		}

		return $returnList;
	}
}
