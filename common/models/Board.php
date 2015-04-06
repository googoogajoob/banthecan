<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "board".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'max_lanes'], 'required'],
            [['id', 'created_at', 'updated_at', 'max_lanes'], 'integer'],
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
     * @return \yii\db\ActiveQuery
     */
    public function getBoardColumns()
    {
        return $this->hasMany(Column::className(), ['board_id' => 'id']);
    }
}
