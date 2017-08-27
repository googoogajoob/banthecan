<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use frontend\models\User;
use frontend\models\blameTrait;


/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $title
 * @property string $description
 * @property integer $ticket_id
 * @property integer $user_id User Responsible for seeing the task is completed
 * @property integer $completed
 */
class Task extends \yii\db\ActiveRecord
{
    use blameTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'ticket_id', 'user_id', 'completed'], 'integer'],
            [['title', 'description'], 'string'],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'ticket_id' => Yii::t('app', 'Ticket'),
            'user_id' => Yii::t('app', 'Responsible'),
            'completed' => Yii::t('app', 'Completed'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getResponsibleName()
    {
        $user = $this->getResponsible()->one();

        return $user ? $user->username : null;
    }

    /**
     * @return string
     */
    public function getResponsibleAvatar()
    {
        $user = $this->getResponsible()->one();

        return $user ? $user->avatarUrlColor : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
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
}