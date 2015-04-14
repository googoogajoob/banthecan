<?php

namespace common\models;

use Yii;
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
 * @property string $title
 * @property string $description
 * @property integer $max_lanes
 *
 * @property BoardColumn[] $boardColumns
 */
class Board extends \yii\db\ActiveRecord
{
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
            [['title', 'description', 'max_lanes'], 'required'],
            [['id', 'created_at', 'created_by', 'updated_by', 'updated_at', 'max_lanes'], 'integer'],
            [['title', 'description'], 'string']
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
    public function getColumns()
    {
        return $this->hasMany(Column::className(), ['board_id' => 'id']);
    }

    /**
     * Returns all Tickets in the backlog of this board
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBacklog()
    {
        return $this->hasMany(Ticket::className(), ['board_id' => 'id'])
            ->where(['column_id' => Ticket::DEFAULT_BACKLOG_STATUS])
            ->orWhere(['column_id' => Ticket::ALTERNATE_BACKLOG_STATUS]);
    }

    /**
     * Returns all active Tickets this board. Assigned to a column.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActive()
    {
        return $this->hasMany(Ticket::className(), ['board_id' => 'id'])
            ->where('column_id > 0');
    }

    /**
     * Returns all completed Tickets this board
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompleted()
    {
        return $this->hasMany(Ticket::className(), ['board_id' => 'id'])
            ->where('column_id < 0');
    }

}
