<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Participant;

/**
 * ParticipantSearch represents the model behind the search form of `app\models\Participant`.
 */
class ParticipantSearch extends Participant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'convention_id'], 'integer'],
            [['role','member_id','room_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Participant::find();
        $query->andFilterWhere(['participant.convention_id'=>\app\models\Convention::getActive()->id]);
        $query->joinWith('member');
        $query->joinWith('room');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'members.lname', $this->member_id]);
        $query->orFilterWhere(['like', 'members.fname', $this->member_id]);
        $query->andFilterWhere(['like', 'room.name', $this->room_id]);

        $query->andFilterWhere(['like', 'participant.role', $this->role]);

        return $dataProvider;
    }
}
