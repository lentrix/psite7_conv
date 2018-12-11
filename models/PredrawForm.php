<?php 

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PredrawForm extends Model
{
	public $raffle_id;
	public $exclusive;

	public function rules()
	{
		return [
			[['raffle_id','exclusive'], 'required'],
			['raffle_id', 'integer'],
			['exclusive', 'boolean']
		];
	}

	public function attributeLabels()
	{
		return [
			'raffle_id' => 'Raffle Item',
			'exclusive' => 'Exclude Previous Winners'
		];
	}
}