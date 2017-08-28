<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "site_news".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $title
 * @property string $description
 */
class SiteNews extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'site_news';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		[['title', 'board_id'], 'required'],
		[['board_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
		[['title', 'description'], 'string'],
		];
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
		];
	}

    public static function find($query = null)
    {
        if (!$query) {
            $query = parent::find();
        }

        $currentActiveBoard = Board::getCurrentActiveBoard();
        if ($currentActiveBoard) {
            $query->andWhere(['board_id' => $currentActiveBoard->id]);
        }

        return $query;
    }

    /**
     * @return \yii\db\ActiveRecord
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    public function getBoardTitle()
    {
        $board = $this->getBoard()->one();

        return $board->title;
    }
}
