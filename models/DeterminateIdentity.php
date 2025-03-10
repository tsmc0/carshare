<?php

namespace app\models;

use yii\web\IdentityInterface;

class DeterminateIdentity
{
    private array $types = [
        0x0 => 'Имя пользователя',
        0x1 => 'email',
        0x2 => 'phone_number',
    ];

    private int $username = 0x0;
    private int $email = 0x1;
    private int $phoneNumber = 0x2;

    public int $type;
    public IdentityInterface $identity;

    /**
     * This method return type definition
     * @param integer $credential An hexadecimal identifier
     * @return string Determinate a type
     * */
    public function getTypeName(int $credential) : string
    {
        return $this->types[$credential];
    }

}