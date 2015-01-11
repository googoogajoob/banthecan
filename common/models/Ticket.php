<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $column_id
 *
 * @property BoardColumn $column
 */
class Ticket extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'user_id', 'title', 'description', 'column_id'], 'required'],
            [['id', 'created_at', 'updated_at', 'user_id', 'column_id'], 'integer'],
            [['title', 'description'], 'string'],
            [['column_id'], 'unique']
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
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'column_id' => 'Column ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumn()
    {
        return $this->hasOne(BoardColumn::className(), ['id' => 'column_id']);
    }
}
