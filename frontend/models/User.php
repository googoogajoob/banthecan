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
        yii::$app->user->on(WebUser::EVENT_AFTER_LOGIN, [$this, 'afterLoginHandler']);
    }

    /**
     * After a User is logged in a Board for ths user must be activated.
     * A user can be a member of 1 or more boards, (or a member of no boards).
     * In normal operation the active board is stored in the session as well as the users Identity cookie.
     * This function checks of this is the case and if not attempts to set things up in this way.
     *
     * The result of this handler depends on the contents of the session and cookie values as wells as
     * the contents of the user's board_id attribute.
     *
     * If the session value is present it will be checked if it is valid and all values set appropriately
     *
     * If no session then the cookie value is checked for validity and all values are set appropriately
     *
     * If neither session nor cookie values exist then the value is determined from the user record
     *
     * The result of this handler depends in part on the contents of the users board_id attribute.
     * It can contain:
     *  - no board ID
     *  - one board ID
     *  - many board IDs
     *
     * If no board Id, cookie and session are set to zero
     * If one board ID, the values are automatically set to this ID
     * Id many board IDs, the values for the session and cookie are set to the first Board ID,
     *
     * @param $event
     */
    public function afterLoginHandler($event)
    {
        $userBoardIds = explode(',', $event->identity->board_id);
        $sessionBoardId = $this->getSessionActiveBoardId();
        $cookieBoardId = $this->getCookieActiveBoardId();

        if ($sessionBoardId) {
            if ($this->boardExists($sessionBoardId) && in_array($sessionBoardId, $userBoardIds)) {
                $this->setCookieActiveBoardId($sessionBoardId);
            } else {
                // deactivate
                $this->setSessionActiveBoardId(0);
                $this->setCookieActiveBoardId(0);
            }
        } elseif ($cookieBoardId) {
            if ($this->boardExists($cookieBoardId) && in_array($cookieBoardId, $userBoardIds)) {
                $this->setSessionActiveBoardId($cookieBoardId);
            } else {
                // deactivate
                $this->setSessionActiveBoardId(0);
                $this->setCookieActiveBoardId(0);
            }
        } elseif (count($userBoardIds)) {
            if ($this->boardExists($userBoardIds[0])) {
                $this->setSessionActiveBoardId($userBoardIds[0]);
                $this->setCookieActiveBoardId($userBoardIds[0]);
            } else {
                // deactivate
                $this->setSessionActiveBoardId(0);
                $this->setCookieActiveBoardId(0);
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

        $cookieCollection-> add(new \yii\web\Cookie([
            'name' => self::ACTIVE_BOARD_COOKIE_NAME,
            'value' => $value
        ]));

        return;
    }

    /**
     * @param $boardId
     * @return null|static
     */
    protected function boardExists($boardId) {
        return Board::findOne($boardId);
    }

}