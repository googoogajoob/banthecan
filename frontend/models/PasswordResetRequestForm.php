<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
	public $email;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		    ['email', 'filter', 'filter' => 'trim'],
		    ['email', 'required'],
		    ['email', 'email'],
		    ['email', 'exist',
                'targetClass' => '\frontend\models\User',
                'filter' => ['in', 'status', [User::STATUS_ACTIVE, User::STATUS_PROTOCOL, User::STATUS_ADMIN, User::STATUS_ADMIN_ONLY]],
                'message' => 'There is no user with such email.'
            ],
        ];
	}

	/**
	 * Sends an email with a link, for resetting the password.
	 *
	 * @return boolean whether the email was send
	 */
	public function sendEmail()
	{
		/* @var $user User */
		$user = User::findOne([
            'status' => [User::STATUS_ACTIVE, User::STATUS_PROTOCOL, User::STATUS_ADMIN, User::STATUS_ADMIN_ONLY],
            'email' => $this->email,
		]);

		if ($user) {
			if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
				$user->generatePasswordResetToken();
			}

			if ($user->save()) {
				return \Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
				->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
				->setTo($this->email)
				->setSubject('Password reset for ' . \Yii::$app->name)
				->send();
			}
		}

		return false;
	}
}
