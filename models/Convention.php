<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "convention".
 *
 * @property int $id
 * @property string $series
 * @property string $date_start
 * @property string $date_end
 * @property string $venue
 * @property string $host_school
 * @property string $chair
 * @property int $active
 *
 * @property Participant[] $participants
 * @property Room[] $rooms
 */
class Convention extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'convention';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['series', 'date_start', 'date_end', 'venue', 'host_school', 'chair'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['active'], 'integer'],
            [['series'], 'string', 'max' => 10],
            [['venue', 'host_school', 'chair'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'series' => 'Series',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'venue' => 'Venue',
            'host_school' => 'Host School',
            'chair' => 'Chair',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['convention_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['convention_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRaffles()
    {
        return $this->hasMany(Raffle::className(), ['convention_id' => 'id']);
    }


    public static function getActive()
    {
        return static::findOne(['active'=>1]);
    }

    public function setAsActive()
    {
        //deactivate all
        $conventions = static::find()->all();
        foreach($conventions as $convention) {
            $convention->active=0;
            $convention->save();
        }

        //activate this
        $this->active = 1;
        $this->save();
    }

    public function getIdentity() {
        return $this->series . " @ " . $this->venue;
    }

    public function getElection() {
        return $this->hasOne(Election::className(), ['convention_id' => 'id']);
    }

    public function updateRoomsOccupants() {
        $rooms = \app\models\Room::find()->where(['convention_id'=>$this->id])->all();
        foreach($rooms as $room) {
            $room->occupants = \app\models\Participant::find()->where(['room_id'=>$room->id])->count();
            $room->save();
        }
    }
}
