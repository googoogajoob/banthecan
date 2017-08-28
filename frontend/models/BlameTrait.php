<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 3/1/16
 * Time: 7:23 PM
 */

namespace frontend\models;

trait BlameTrait
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return string
     */
    public function getCreatedByName()
    {
        $user = $this->getCreatedBy()->one();

        return $user ? $user->username : null;
    }

    /**
     * @return string
     */
    public function getCreatedByAvatar()
    {
        $user = $this->getCreatedBy()->one();

        return $user ? $user->avatarUrlColor : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return string
     */
    public function getUpdatedByName()
    {
        $user = $this->getUpdatedBy()->one();

        return $user ? $user->username : null;
    }

    /**
     * @return string
     */
    public function getUpdatedByAvatar()
    {
        $user = $this->getUpdatedBy()->one();

        return $user ? $user->avatarUrlColor : null;
    }

}