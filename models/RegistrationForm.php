<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
/**
 * LoginForm is the model behind the login form.
 */
class RegistrationForm extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    public $passwordConfirm;
    /**
     * @return array the validation rules.
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'password_hash', 'passwordConfirm'], 'required'],
            ['login', 'unique'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password_hash'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['created_at', 'default', 'value' => time()]
        ];
    }
}