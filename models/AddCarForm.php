<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddCarForm extends Model
{

    public $brand;
    public $coast_per_hour;
    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['brand'], 'required'],
            ['coast_per_hour', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'brand' => 'Марка',
            'coast_per_hour' => 'Стоимость аренды в час (₽)',
        ];
    }
}
