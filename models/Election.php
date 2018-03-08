<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "election".
 *
 * @property int $id
 * @property int $convention_id
 * @property string $election_officer
 * @property int $no_of_winners
 *
 * @property Candidate[] $candidates
 * @property Convention $convention
 */
class Election extends \yii\db\ActiveRecord
{
    const STATUS_PREP = 0;
    const STATUS_NOMIATION = 1;
    const STATUS_ON_GOING = 2;
    const STATUS_CLOSED = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'election';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['convention_id', 'election_officer'], 'required'],
            [['convention_id', 'no_of_winners'], 'integer'],
            [['election_officer'], 'string', 'max' => 100],
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
            'election_officer' => 'Election Officer',
            'no_of_winners' => 'No Of Winners',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidates()
    {
        return $this->hasMany(Candidate::className(), ['election_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvention()
    {
        return $this->hasOne(Convention::className(), ['id' => 'convention_id']);
    }

    public function getStatusText()
    {
        switch($this->status){
            case 0 : return "Preparatory";
            case 1 : return "Nomination";
            case 2 : return "On-going";
            case 3 : return "Closed";
        }
    }
}
