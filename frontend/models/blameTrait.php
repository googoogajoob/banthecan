<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 3/1/16
 * Time: 7:23 PM
 */

namespace frontend\models;

trait blameTrait
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return string
     */
    public function getCreatedByName() {
        return $this->getCreatedBy()->one()->username;
    }

    /**
     * @return string
     */
    public function getCreatedByAvatar() {
        return $this->getCreatedBy()->one()->avatarUrlColor;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return string
     */
    public function getUpdatedByName() {
        return $this->getUpdatedBy()->one()->username;
    }

    /**
     * @return string
     */
    public function getUpdatedByAvatar() {
        return $this->getUpdatedBy()->one()->avatarUrlColor;
    }

}