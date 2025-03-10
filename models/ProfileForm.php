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
class ProfileForm extends Model
{

    public $username;
    public $first_name;
    public $second_name;
    public $father_name;
    public $email;
    public $phone_number;
    public $passport;
    public $drive_license;
    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['email', 'phone_number', 'passport', 'drive_license'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'EMAIL',
            'phone_number' => 'Номер телефона',
            'passport' => 'Серия и номер паспорта',
            'drive_license' => 'Номер ВУ',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'father_name' => 'Отчество',
        ];
    }
}
