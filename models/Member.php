<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "members".
 *
 * @property int $id
 * @property string $lname
 * @property string $fname
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property string $school
 * @property string $designation
 * @property string $phone
 * @property string $authKey
 * @property int $role
 */
class Member extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lname', 'fname', 'email', 'nickname', 'password'], 'required'],
            [['role'], 'integer'],
            [['lname', 'fname', 'designation', 'authKey'], 'string', 'max' => 45],
            [['email', 'password'], 'string', 'max' => 255],
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
            'school' => 'School',
            'designation' => 'Designation',
            'phone' => 'Phone',
            'authKey' => 'Auth Key',
            'role' => 'Role',
            'active' => 'Status',
            'statusText' => 'Status'

        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'active'=>1]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username, 'active'=>1]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function getFullName()
    {
        return $this->lname . ", " . $this->fname;
    }

    public function getStatusText()
    {
        return $this->active?"Active":"Inactive";
    }

    public function getIsParticipant(){
        return $participant = \app\models\Participant::findOne(['member_id'=>$this->id, 'convention_id'=>\app\models\Convention::getActive()->id]);
    }

    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['member_id' => 'id']);
    }
}
