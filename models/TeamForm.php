<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TeamForm extends Model
{
    public $title;
    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название группы',
        ];
    }

}
