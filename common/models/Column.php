<?php

namespace common\models;

use Yii;
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
 * @property string  $title
 * @property integer $display_order
 * @property integer $receiver
 *
 * @property Board $board
 * @property Ticket[] $tickets
 */
class Column extends \yii\db\ActiveRecord
{

    const DEMO_COLUMNS = [
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
            [['title','receiver'], 'string']
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
            'board_id' => 'Board ID',
            'title' => 'Title',
            'display_order' => 'Display Order',
        ];
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
     * Creates a set of Demo Columns
     *
     * @return boolean
     */
    public function createDemoColumns($boardId) {

        $this->deleteAll();

        foreach (self::DEMO_COLUMNS as $demoColumn) {
            $this->title =          $demoColumn['title'];
            $this->display_order =  $demoColumn['order'];
            $this->receiver =       $demoColumn['receiver'];;
            $this->board_id = $boardId;
            $this->isNewRecord = true;
            $this->id = null;
            if (!$this->save()) {
                return false;
            }
        }

        return true;
    }

}
