<?php

namespace common\models;

use Faker\Factory;
use yii;
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

    const NO_ACTIVE_BOARD_MESSAGE = 'An Active Board Has Not Been Set';
    const NO_ACTIVE_BOARD_STATUS_TEST = 0;
    const DEMO_TITLE = 'Ban-The-Can Demonstration Board';
    const DEMO_MAX_LANES = 1;

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
            [['title', 'description', 'max_lanes', 'entry_column'], 'required'],
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

            return true;
        }

        return false;
    }

    public function afterFind() {
        parent::afterFind();
        $this->ticket_backlog_configuration = unserialize($this->ticket_backlog_configuration);
        $this->ticket_completed_configuration = unserialize($this->ticket_completed_configuration);
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
     *
     * @throws yii\web\NotFoundHttpException
     * @return \yii\db\ActiveRecord
     */
    public static function getActiveboard() {

        $session = Yii::$app->session;
        $currentBoardId = $session->get('currentBoardId');

        if ($currentBoardId == self::NO_ACTIVE_BOARD_STATUS_TEST) {
            $session->setFlash('warning', self::NO_ACTIVE_BOARD_MESSAGE);
            return null;
        } else {
            Ticket::restrictQueryToBoard($currentBoardId);
            return self::findOne($currentBoardId);
        }
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

            if ($this->save()) {
                return $this;
            }
        }

        return null;
    }

}