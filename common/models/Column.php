<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "board_column".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $board_id
 * @property string  $title
 * @property integer $display_order
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
        return 'board_column';
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
            [['board_id', 'name'], 'required'],
            [['id', 'created_at', 'updated_at', 'board_id', 'display_order'], 'integer'],
            [['title'], 'string']
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
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['column_id' => 'id']);
    }
}
