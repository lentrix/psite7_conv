<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "raffle".
 *
 * @property int $id
 * @property string $created
 * @property int $created_by
 * @property int $convention_id
 * @property string $prize
 * @property int $participant_id
 * @property string $drawn
 *
 * @property Convention $convention
 * @property Members $createdBy
 * @property Participant $participant
 */
class Raffle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'raffle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'drawn'], 'safe'],
            [['created_by', 'convention_id', 'prize'], 'required'],
            [['created_by', 'convention_id', 'participant_id'], 'integer'],
            [['prize'], 'string', 'max' => 90],
            [['convention_id'], 'exist', 'skipOnError' => true, 'targetClass' => Convention::className(), 'targetAttribute' => ['convention_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Member::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'created' => 'Created',
            'created_by' => 'Created By',
            'convention_id' => 'Convention ID',
            'prize' => 'Prize',
            'participant_id' => 'Participant ID',
            'drawn' => 'Drawn',
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
    public function getCreatedBy()
    {
        return $this->hasOne(Member::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }
}
