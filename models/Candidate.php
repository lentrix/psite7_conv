<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "candidate".
 *
 * @property int $id
 * @property int $election_id
 * @property int $participant_id
 * @property string $remarks
 *
 * @property Election $election
 * @property Participant $participant
 * @property Vote[] $votes
 */
class Candidate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'candidate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['election_id', 'participant_id'], 'required'],
            [['election_id', 'participant_id'], 'integer'],
            [['remarks'], 'string', 'max' => 45],
            [['election_id'], 'exist', 'skipOnError' => true, 'targetClass' => Election::className(), 'targetAttribute' => ['election_id' => 'id']],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'election_id' => 'Election ID',
            'participant_id' => 'Participant ID',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElection()
    {
        return $this->hasOne(Election::className(), ['id' => 'election_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }

    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id'=>'member_id'])
            ->via('participant');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Vote::className(), ['candidate_id' => 'id']);
    }
}
