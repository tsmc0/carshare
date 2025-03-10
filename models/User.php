<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $identity
     * @return DeterminateIdentity|null
     */
    public static function findUserByIdentity(string $identity): ?DeterminateIdentity
    {
        return self::determineCredentialType($identity);
    }

    /**
     * These method find identity by its credential
     * @param string $credential
     * @return DeterminateIdentity
     */
    private static function determineCredentialType(string $credential): ?DeterminateIdentity
    {
        $preparedContent = [
          ['username' => $credential],
          ['email' => $credential],
          ['phone_number' => $credential],
        ];

        foreach ($preparedContent as $needle => $credential_value) {
            if (self::find()->where($credential_value)->exists()) {
                $di = new DeterminateIdentity;
                $di->identity = self::findOne($credential_value);
                $di->type = $needle;

                return $di;
            }

            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        //return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (self::find()->where(['username' => $this->username])->exists()) {
            return false;
        }

        return parent::beforeSave($insert);
    }

}
