<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use frontend\models\BlameTrait;

/**
 * This is the model class for table "resolution".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $title
 * @property string $description
 * @property integer $ticket_id
 */

class Resolution extends FindFromBoard
{
    use BlameTrait;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'resolution';
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
	public function rules()
	{
		return [
		[['title'], 'required'],
		[['created_at', 'updated_at', 'created_by', 'updated_by', 'ticket_id'], 'integer'],
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
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTicket() {
		return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
	}

}
