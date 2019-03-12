<?php 

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Member
{
    public $password_repeat;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lname', 'fname', 'email', 'nickname', 'password','password_repeat'], 'required'],
            ['password','compare','compareAttribute'=>'password_repeat'],
            [['role'], 'integer'],
            [['lname', 'fname', 'designation', 'authKey'], 'string', 'max' => 45],
            [['email', 'password','password_repeat'], 'string', 'max' => 255],
            [['school'], 'string', 'max' => 191],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lname' => 'Last Name',
            'fname' => 'First Name',
            'nickname' => 'Nickname',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
            'school' => 'School',
            'designation' => 'Designation',
            'phone' => 'Phone',
            'authKey' => 'Auth Key',
            'role' => 'Role',
            'active' => 'Status',
            'statusText' => 'Status'

        ];
    }
}