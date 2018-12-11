<?php 

namespace app\models;

use Yii;
use yii\base\Model;

class Ballot extends Model
{
	public $votes;
		
	public function rules() {
		return [
			[['votes'], 'limitNumber']
		];
	}

	public function limitNumber($attribute_name, $params) {
			$limit = Convention::getActive()->election->no_of_winners;
        	if(count($this->$attribute_name) > $limit) {
            $this->addError($attribute_name, "Votes cannot exceed " . $limit);
            return false;
        	}
        	return true;
    }
}
?>