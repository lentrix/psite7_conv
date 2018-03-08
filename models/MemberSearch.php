<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "members".
 *
 * @property int $id
 * @property string $lname
 * @property string $fname
 * @property string $email
 * @property string $password
 * @property string $school
 * @property string $designation
 * @property string $phone
 * @property string $authKey
 * @property int $role
 */
class MemberSearch extends Member 
{
	public function rules() {
		return [
            ['id', 'integer'],
            [['lname','fname','school','designation','email'], 'safe'],
        ];
	}

	public function search($params)
    {
        $query = Member::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'lname', $this->lname])
            ->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'school', $this->school])
            ->andFilterWhere(['like', 'designation', $this->designation]);

        return $dataProvider;
    }
}