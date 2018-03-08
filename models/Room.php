<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property int $convention_id
 * @property string $name
 * @property int $capacity
 *
 * @property Participant[] $participants
 * @property Convention $convention
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['convention_id', 'name', 'capacity'], 'required'],
            [['convention_id', 'capacity'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['convention_id'], 'exist', 'skipOnError' => true, 'targetClass' => Convention::className(), 'targetAttribute' => ['convention_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'convention_id' => 'Convention ID',
            'name' => 'Name',
            'capacity' => 'Capacity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvention()
    {
        return $this->hasOne(Convention::className(), ['id' => 'convention_id']);
    }
}
