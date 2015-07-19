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
     *
     * todo: as of 20-Apr-2015 this method is not used, perhaps it could be removed
     *
     * @return \yii\db\ActiveRecord
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id'])
                    ->one();
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
}
