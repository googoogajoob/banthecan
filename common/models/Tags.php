<?php

namespace common\models;

use Yii;
use common\models\Ticket;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property integer $frequency
 * @property string $name
 */
class Tags extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'tags';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
		[['frequency', 'name'], 'required'], //id removed, new tags are not saved when it is required
		[['id', 'frequency'], 'integer'],
		[['name'], 'string']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
            'id' => 'ID',
            'frequency' => 'Frequency',
            'name' => 'Name',
		];
	}

	public function afterDelete()
	{
		$this->getDb()
		->createCommand()
		->delete(Ticket::TICKET_TAG_MM_TABLE, ['tag_id' => $this->id])
        ->execute();

		parent::afterDelete();
	}
	/**
	 * Return Ticket IDs of Tickets which contain tag names
	 *
	 * @param $tagSearch string/array list of Tag Names to search for (when string CSV)
	 * @return array
	 */
	public static function getTicketId($tagSearch) {
		// tagSearch can be string or array
		// If empty then return empty array
		// The goal is to create an array of Tag Names for the sql IN clause
		if (is_array($tagSearch)) {
			if (count($tagSearch)) {
				$tagSearchValues = $tagSearch;
			} else {
				//nothing to search for return empty array
				return [];
			}
		} elseif (is_string($tagSearch)) {
			if (trim($tagSearch) == '') {
				//nothing to search for return empty array
				return [];
			} else {
				$tagSearchValues = explode(',', $tagSearch);
			}
		} else {
			//nothing to search for return empty array
			return [];
		}

		return Tags::find()
		->select(Ticket::TICKET_TAG_MM_TABLE . '.`ticket_id` id')
		->innerJoin(Ticket::TICKET_TAG_MM_TABLE, '.`tags`.`id` = ' . Ticket::TICKET_TAG_MM_TABLE . '.`tag_id`')
		->where(['`tags`.`name`' => $tagSearchValues])
		->asArray()
		->all();
	}

	/**
	 * Needed for creating Records in the DEMO DB.
	 * When Tags are deleted the ticket_tag_mm table should be cleared also
	 */
	public static function deleteAllDemoTags($condition = null) {
		//parent::deleteAll($condition);

		$command = static::getDb()->createCommand();
		$command->delete(Ticket::TICKET_TAG_MM_TABLE);

		return $command->execute();
	}
}
