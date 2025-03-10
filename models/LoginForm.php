<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    private array $resJustifications = [
        0x0 => 'Redirect to signup',
        0x1 => 'Redirect to login',
        0x2 => 'Incorrect username or password',
        0x3 => 'Successfully authorized',
    ];

    // No identity was found, need redirect to signup
    private int $noIdentity = 0x0;

    // Identity was found, need get password
    private int $foundIdentity = 0x1;

    private int $passwordFail = 0x2;
    private int $successAuth = 0x3;

    public $credential;
    public $password;
    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['credential'], 'required'],
            ['password', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'credential' => 'Логин/EMAIL/Номер телефона',
            'password' => 'Пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, array $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный логин/пароль');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     */
    public function login()
    {
        //if ($this->validate()) {
        return (is_null($u = User::findUserByIdentity($this->credential)))
            ? ['state' => $this->noIdentity, 'content' => $this->resJustifications[$this->noIdentity]]
            : ['state' => $this->foundIdentity, 'content' => $u->identity->first_name];

        //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        //}

        //return null;
    }

    public function checkPassword(): array
    {
        if (!is_null($u = User::findUserByIdentity($this->credential))) {
            if ($u->identity->validatePassword($this->password)) {
                if (Yii::$app->user->login($u->identity, 3600*24*30)) {
                    return ['state' => $this->successAuth, 'content' => $this->resJustifications[$this->successAuth]];
                } else {
                    return ['state' => $this->passwordFail, 'content' => 'AUTH Failure'];
                }
            } else {
                return ['state' => $this->passwordFail, 'content' => $this->resJustifications[$this->passwordFail]];
            }
        } else {
            return ['state' => $this->noIdentity, 'content' => $this->resJustifications[$this->noIdentity]];
        }
    }

    /**
     * Finds user by given credential
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return (is_null($u = User::findUserByIdentity($this->credential))) ? null : $u->identity;
    }
}
