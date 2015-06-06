<?php

namespace common\models;

use Yii;

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
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency', 'name'], 'required'], //id removed, new tags are not saved when it is required
            [['id', 'frequency'], 'integer'],
            [['name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frequency' => 'Frequency',
            'name' => 'Name',
        ];
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
                //nothing to search for return empty list
                return [];
            }
        } elseif (is_string($tagSearch)) {
            if (trim($tagSearch) == '') {
                //nothing to search for return empty list
                return [];
            } else {
                $tagSearchValues = explode(',', $tagSearch);
            }

        }

        return Tags::find()
            ->select('`ticket_tag_mm`.`id`')
            ->innerJoin('ticket_tag_mm', '`tags`.`id` = `ticket_tag_mm`.`tag_id`')
            ->where(['tags.name' => $tagSearchValues])
            ->asArray()
            ->all();
    }
}
