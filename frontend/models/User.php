<?php
namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;
use yii\web\User as WebUser;
use common\models\Board;

/**
 * This class extends the more generic User Identity Class from the common branch
 * It's main purpose is to provide functionality for managing the active board status
 * In the session and cookies.
 *
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
 * @property integer $board_id
 *
 */
class User extends \common\models\User implements IdentityInterface
{

	const ACTIVE_BOARD_COOKIE_NAME = 'activeBoard'; // Cookie Name for the active Board
	const ACTIVE_BOARD_SESSION_VARIABLE_NAME = 'activeBoard'; // Variable Name for the active Board used in the Session

	/**
	 *
	 */
	public function init()
	{
		parent::init();
		yii::$app->user->on(WebUser::EVENT_AFTER_LOGIN, [$this, 'afterLoginHandler']);
	}

	/**
	 * After a User is logged in, a Board for this user will be activated.
	 *
	 * A user can be a member of zero, one or more boards (when zero the user is automatically logged out).
	 *
	 * In normal operation the active board is stored in the session as well as the Active Board cookie.
	 * This function checks if this is the case and if not, attempts to set things up in this way.
	 *
	 * The result of this handler depends on the contents of the session and cookie values as well as
	 * the contents of the user's board_id attribute.
	 *
	 * If the session value is present it will be checked if it is valid and all values set appropriately
	 *
	 * If no session then the cookie value is checked for validity and all values are set appropriately
	 *
	 * If neither session nor cookie values exist then the value is determined from the user record
	 *
	 * The contents of the users board_id attribute are evaluated as follows:
	 * It can contain:
	 *  - no board ID
	 *  - one board ID
	 *  - many board IDs
	 *  - (in addition, board IDs can be valid or invalid, i.e. the corresponding Board exists)
	 *
	 * If no board Id, cookie and session are set to zero
	 * If one board ID, the values are automatically set to this ID
	 * Id many board IDs, the values for the session and cookie are set to the first valid Board ID,
	 *
	 * @param $event Yii\web\UserEvent
	 */
	public function afterLoginHandler($event)
	{
		$userBoardIds = explode(',', $event->identity->board_id);
		$sessionBoardId = $this->getSessionActiveBoardId();
		$cookieBoardId = $this->getCookieActiveBoardId();

		if ($sessionBoardId) {
			if ($this->boardExists($sessionBoardId) && in_array($sessionBoardId, $userBoardIds)) {
				$this->activateBoard($sessionBoardId);
			} else {
				$this->deactivateAllBoards();
			}
		} elseif ($cookieBoardId) {
			if ($this->boardExists($cookieBoardId) && in_array($cookieBoardId, $userBoardIds)) {
				$this->activateBoard($cookieBoardId);
			} else {
				$this->deactivateAllBoards();
			}
		} elseif (count($userBoardIds)) {
			// Find the first Board Id from the user which actually exists as a Board
			$boardFound = false;
			foreach($userBoardIds as $searchForBoardId) {
				if ($this->boardExists($searchForBoardId)) {
					$boardFound = $searchForBoardId;
					break;
				}
			}
			if ($boardFound) {
				$this->activateBoard($boardFound);
			} else {
				$this->deactivateAllBoards();
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getSessionActiveBoardId()
	{
		return Yii::$app->getSession()->get(self::ACTIVE_BOARD_SESSION_VARIABLE_NAME);
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function setSessionActiveBoardId($value)
	{
		return Yii::$app->getSession()->set(self::ACTIVE_BOARD_SESSION_VARIABLE_NAME, $value);
	}

	/**
	 * @return string
	 */
	public function getCookieActiveBoardId()
	{
		return Yii::$app->request->getCookies()->getValue(self::ACTIVE_BOARD_COOKIE_NAME, 0);
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function setCookieActiveBoardId($value)
	{
		$cookieCollection = Yii::$app->response->getCookies();

		return $cookieCollection->add(new \yii\web\Cookie([
            'name' => self::ACTIVE_BOARD_COOKIE_NAME,
            'value' => $value,
			'expire' => time() + 7 * 24 * 60 * 60
		]));
	}

	/**
	 * Returns the active board ID for this user. Session has precedence over the Cookie value
	 *
	 * @return mixed|string
	 */
	public function getUserActiveBoardId()
	{
		$sessionBoardId = $this->getSessionActiveBoardId();
		$cookieBoardId = $this->getCookieActiveBoardId();

		return $sessionBoardId ? $sessionBoardId : $cookieBoardId;
	}

	/**
	 * Sets the session and cookie values to be 0, i.e. inactive for this user
	 */
	public function deactivateAllBoards()
	{
		$this->setSessionActiveBoardId(0);
		$this->setCookieActiveBoardId(0);
	}

	/**
	 * Sets the session and cookie values to be $boardId
	 *
	 * @param $boardId
	 */
	public function activateBoard($boardId)
	{
		if ($this->boardExists($boardId)) {
			$this->setSessionActiveBoardId($boardId);
			$this->setCookieActiveBoardId($boardId);
            Board::setActiveBoard();
		} else {
			$this->deactivateAllBoards();
		}
	}

	/**
	 * @param $boardId
	 * @return null|static
	 */
	protected function boardExists($boardId)
	{
		return Board::findOne($boardId);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'username' => \Yii::t('app', 'Username'),
			'password' => \Yii::t('app', 'Password'),
		];
	}


}