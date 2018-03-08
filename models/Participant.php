<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participant".
 *
 * @property int $id
 * @property int $member_id
 * @property int $convention_id
 * @property int $room_id
 * @property string $role
 *
 * @property Convention $convention
 * @property Members $member
 * @property Room $room
 */
class Participant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'convention_id','role'], 'required'],
            [['member_id', 'convention_id', 'room_id'], 'integer'],
            [['role'], 'string', 'max' => 45],
            [['convention_id'], 'exist', 'skipOnError' => true, 'targetClass' => Convention::className(), 'targetAttribute' => ['convention_id' => 'id']],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::className(), 'targetAttribute' => ['member_id' => 'id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member',
            'convention_id' => 'Convention ID',
            'room_id' => 'Room',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvention()
    {
        return $this->hasOne(Convention::className(), ['id' => 'convention_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }
}
