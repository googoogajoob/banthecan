<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const DEMO_USER_NAME = 'demo';
    const DEMO_USER_PASSWORD = 'demo';

    /**
     * @var string configurable Directory Path for Color Avatars
     */
    public static $avatarPathColor = '/images/content/30x40/';

    /**
     * @var string configurable Directory Path for Grayscale Avatars
     */
    public static $avatarPathGray = '/images/content/30x40-gray/';

    /**
     * @var string configurable Root File Name for all Avatars
     */
    public static $avatarFilenameRoot = 'user-';

    /**
     * @var string configurable Filename Extension for all Avatars
     */
    public static $avatarFilenameExtension = 'jpg';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Attribute AvatarUrlColor is returned. The virtual attribute is defined by combining
     * a configured path, filenameRoot as well as a filenameExtension together with the user_id
     * to form a complete file/path name
     *
     * @return string
     */
    public function getAvatarUrlColor() {
        return self::makeAvatarUrl($this->id, true);
    }

    /**
     * Attribute AvatarUrlGray is returned. The virtual attribute is defined by combining
     * a configured path, filenameRoot as well as a filenameExtension together with the user_id
     * to form a complete file/path name
     *
     * @return string
     */
    public function getAvatarUrlGray() {
        return self::makeAvatarUrl($this->id, false);
    }

    /**
     * A static function for building an Avatar URL. This may be preferable to the non-static
     * versions as it enables the creation of the URL without reading the User Record
     * from the database. If you have a valid User-Id (e.g. from another related record)
     * you can retrieve the URL.
     *
     * The URL is defined by combining
     * a configured path, filenameRoot as well as a filenameExtension together with the user_id
     * to form a complete file/path name
     *
     * @param integer $id user_id
     * @param boolean $color TRUE for the Color Avatar, False for Grayscale
     * @return string The Avatar URL or Empty String if $id == false
     */
    public static function getAvatarUrl($id = null, $color = true) {
        return self::makeAvatarUrl($id, $color);
    }
    /**
     * This function is used internally (thus the protected keyword) to generate a URL for
     * an Avatar-Image of a user based on their Id
     *
     * @param integer $id user_id
     * @param  boolean $color TRUE for the Color Avatar, False for Grayscale
     * @return string Avatar Pathname or empty string if Id is invalid
     */
    protected static function makeAvatarUrl($id = null, $color = true) {
        if ($id) {
            $filename = self::$avatarFilenameRoot . $id . '.' . self::$avatarFilenameExtension;
            if ($color) {
                return  self::$avatarPathColor . $filename;
            } else {
                return  self::$avatarPathGray . $filename;
            }
        } else {
            return '';
        }
    }

    /**
     * Returns a list of all users who are associated with the current active board.
     */
    public static function getBoardUsers() {
        return self::find()->where(Board::getActiveboard()->id . ' in (board_id)')->all();
    }

    /**
     * Creates a Demo User
     *
     * @return $this|null
     */
    public function createDemoUser() {
			$this->deleteAll();
        $this->username = self::DEMO_USER_NAME;
        $this->password = self::DEMO_USER_PASSWORD;
        $this->email = '';
        $this->board_id = 1;
        $this->password_reset_token = '';
        $this->setPassword('demo');
        $this->generateAuthKey();
        if ($this->save()) {
            return $this;
        }

        return null;
    }

    public static function findDemoUser() {
        return static::findByUsername(self::DEMO_USER_NAME);
    }
}
