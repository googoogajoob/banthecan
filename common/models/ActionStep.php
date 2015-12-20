<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "action_step".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $title
 * @property string $description
 * @property integer $ticket_id
 * @property integer $user_id
 */
class ActionStep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action_step';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'title', 'description', 'ticket_id', 'user_id'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'ticket_id', 'user_id'], 'integer'],
            [['title', 'description'], 'string'],
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
            'title' => 'Title',
            'description' => 'Description',
            'ticket_id' => 'Ticket ID',
            'user_id' => 'User ID',
        ];
    }
}
