<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddCarGroupForm extends Model
{

    public $auto;
    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['auto'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'auto' => 'Авто',
        ];
    }
}
