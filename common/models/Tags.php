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
            [['id', 'frequency', 'name'], 'required'],
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
}
