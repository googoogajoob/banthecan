<?php

namespace common\models;

use Faker\Factory;
use yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "board".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string  $title
 * @property string  $description
 * @property integer $max_lanes
 * @property string  $backlog_name
 * @property string  $kanban_name
 * @property string  $completed_name
 * @property string  $ticket_backlog_configuration
 * @property string  $ticket_completed_configuration
 * @property integer $entry_column
 * @property BoardColumn[] $boardColumns
 *
 */
class Board extends \yii\db\ActiveRecord {

	const NO_ACTIVE_BOARD_MESSAGE = 'An active board must be <a href="/board/select">selected</a> in order to proceed.';
	const DEMO_TITLE = 'Ban-The-Can Demonstration Board';
	const DEMO_MAX_LANES = 1;
	public static $boardName = [];
	protected static $currentActiveBoard = null;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
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
		[['title', 'description'], 'required'],
		[['id', 'created_at', 'created_by', 'updated_by', 'updated_at', 'max_lanes', 'entry_column'], 'integer'],
		[['title', 'description', 'backlog_name', 'kanban_name', 'completed_name'], 'string'],
		[['ticket_backlog_configuration', 'ticket_completed_configuration'],
                'in',
                'range' => Yii::$app->ticketDecorationManager->getAvailableTicketDecorations(),
                'allowArray' => true],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
            'id' => 'ID',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'created_by' => 'Creator',
            'updated_by' => 'Updater',
            'title' => 'Title',
            'description' => 'Description',
            'max_lanes' => 'Max Lanes',
            'backlog_name' => 'Backlog Name',
            'kanban_name' => 'Kanban Name',
            'completed_name' => 'Completed Name',
            'ticket_backlog_configuration' => 'Backlog Ticket Decorations',
            'ticket_completed_configuration' => 'Completed Ticket Decorations',
            'entry_column' => 'Entry Column'
            ];
	}

	/**
	 * @param bool $insert
	 * @return bool
	 */
	public function beforeSave($insert) {

		if (parent::beforeSave($insert)) {
			$this->ticket_backlog_configuration = serialize($this->ticket_backlog_configuration);
			$this->ticket_completed_configuration = serialize($this->ticket_completed_configuration);

            if ($this->max_lanes < 1) {
                $this->max_lanes = 1;
            }

			return true;
		}

		return false;
	}

	public function afterFind() {
		parent::afterFind();

        self::$boardName = [];

        if ($this) {
            $this->ticket_backlog_configuration = unserialize($this->ticket_backlog_configuration);
            $this->ticket_completed_configuration = unserialize($this->ticket_completed_configuration);

			if (!is_array($this->ticket_backlog_configuration)) {
				$this->ticket_backlog_configuration = [];
			}

			if (!is_array($this->ticket_completed_configuration)) {
				$this->ticket_completed_configuration = [];
			}

            if (trim($this->kanban_name) != '') {
                self::$boardName['kanban'] = $this->kanban_name;
            }
            if (trim($this->backlog_name) != '') {
                self::$boardName['backlog'] = $this->backlog_name;
            }
            if (trim($this->completed_name) != '') {
                self::$boardName['completed'] = $this->completed_name;
            }
        }
	}

    public static function getBacklogName() {
        if (isset(self::$boardName['backlog'])) {
            return self::$boardName['backlog'];
        } else {
            return Yii::t('app', 'Backlog');
        }
    }

    public static function getKanbanName() {
        if (isset(self::$boardName['kanban'])) {
            return self::$boardName['kanban'];
        } else {
            return Yii::t('app', 'Kanban');
        }
    }

    public static function getCompletedName() {
        if (isset(self::$boardName['completed'])) {
            return self::$boardName['completed'];
        } else {
            return Yii::t('app', 'Completed');
        }
    }

    public static function getBoardSectionName($boardSection) {
        switch ($boardSection)
        {
            case 'backlog':
                $boardSectionName = self::getBacklogName();
                break;
            case 'kanban':
                $boardSectionName = self::getKanbanName();
                break;
            case 'completed':
                $boardSectionName = self::getCompletedName();
                break;
            default:
                $boardSectionName = 'Board';
                break;
        }

        return $boardSectionName;
    }

	/**
	 * Returns the Kanban Columns associated with this board
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getColumns()
    {
		return $this->hasMany(Column::className(), ['board_id' => 'id'])
		->orderBy('display_order')
		->all();
	}

	public function getEntryColumn()
    {
		return $this->hasOne(Column::className(), ['id' =>'entry_column']);
	}

	public function getEntryColumnName()
    {
        $entryColumn = $this->getEntryColumn()->one();

		return $entryColumn ? $entryColumn->title : '';
	}

	/**
	 * Retrieves the current active board record corresponding to the current board ID for this session or cookie
	 *
	 * @return \yii\db\ActiveRecord | null when board record not found
	 */
	public static function getActiveBoard()
	{
		$userRecord = Yii::$app->user->identity;
		$newActiveBoard = false;

		if ($userRecord) {
			if ($lookForBoardId = $userRecord->getUserActiveBoardId()) {
				$newActiveBoard = self::findOne($lookForBoardId);
			}
		}

		if ($newActiveBoard) {
			return $newActiveBoard;
		} else {
			Yii::$app->session->setFlash('warning', \Yii::t('app', self::NO_ACTIVE_BOARD_MESSAGE));
			return null;
		}
	}

    public static function getCurrentActiveBoard()
    {
        return self::$currentActiveBoard;
    }

	/**
	 * Creates a Demo Board
	 *
	 * @return $this|null
	 */
	public function createDemoBoard() {
		if (YII_ENV_DEMO) {
			$faker = Factory::create();

			$this->deleteAll();
			$this->title = self::DEMO_TITLE;
			$this->max_lanes = self::DEMO_MAX_LANES;
			$this->description = "Description Text: " . $faker->text();
			$this->entry_column = 0; // Temp value until the Demo Columns are created,

			$decorationClasses = Yii::$app->ticketDecorationManager->getAvailableTicketDecorations();
			$this->ticket_backlog_configuration = [
			$decorationClasses[1],
			$decorationClasses[2],
			$decorationClasses[3],
			$decorationClasses[4],
			];
			$this->ticket_completed_configuration = [
			$decorationClasses[0],
			$decorationClasses[1],
			$decorationClasses[3],
			$decorationClasses[4],
			];

			if ($this->save()) {
				return $this;
			}
		}

		return null;
	}

}