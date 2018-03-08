<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote".
 *
 * @property int $id
 * @property int $participant_id
 * @property int $candidate_id
 *
 * @property Candidate $candidate
 * @property Participant $participant
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['participant_id', 'candidate_id'], 'required'],
            [['participant_id', 'candidate_id'], 'integer'],
            [['candidate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Candidate::className(), 'targetAttribute' => ['candidate_id' => 'id']],
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
            'participant_id' => 'Participant ID',
            'candidate_id' => 'Candidate ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidate()
    {
        return $this->hasOne(Candidate::className(), ['id' => 'candidate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }
}
