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
class SignupForm extends Model
{
    public $first_name;
    public $second_name;
    public $father_name;
    public $username;
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['password', 'first_name', 'second_name', 'email', 'username'], 'required'],
            ['email', 'email'],
            ['father_name', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'father_name' => 'Отчество',
            'email' => 'EMAIL',
            'password' => 'Пароль',
        ];
    }

    public function write()
    {
        if (is_null(User::findOne(['username' => $this->username])) && is_null(User::findOne(['email' => $this->email]))) {
            $user = new User();
            $user->first_name = $this->first_name;
            $user->second_name = $this->second_name;
            $user->father_name = $this->father_name;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->email = $this->email;
            $user->username = $this->username;


            return $user->save();
        }

        return false;
    }
}
