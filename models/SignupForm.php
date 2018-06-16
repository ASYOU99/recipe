<?php
namespace app\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;
use yii\base\Model;
use app\models\UserModel;

/**
 * Signup form
 */
class SignupForm extends Model
{


    public $username;
    public $email;
    public $password;
    public $reCaptcha;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'targetClass' => 'app\models\UserModel', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\UserModel', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 2, 'max' => 30],
            ['password', 'match', 'pattern' => '/^[\*a-zA-Z0-9]{2,30}$/','message'=>'Допускается только латиница и цифры'],
            [['reCaptcha'], 'required','message'=>'Пройдите, пожалуйста, аутентификацию'],

            ['reCaptcha', ReCaptchaValidator::class,
                'secret' => \Yii::$app->components['reCaptcha']["secret"],
                'skipOnEmpty' => true,
            ]
            ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Имя'),
            'email' => Yii::t('app', 'Email'),
            'reCaptcha' => Yii::t('app', 'Капча'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return UserModel|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserModel();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
