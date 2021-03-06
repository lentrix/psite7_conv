<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionAdduser($username, $password, $role) {
    	$user = new \app\models\User;
    	$user->username = $username;
    	$user->setPassword($password);
    	$user->role = $role;
    	$user->save();
    	echo "New user has been created.";
    }

    public function actionNonWinners(){

        $winningIds =  (new \yii\db\Query())
                    ->select(['participant_id'])
                    ->from('raffle')
                    ->where(['not', 'drawn IS NULL'])
                    ->all();

        $participants = \app\models\Participant::find()->where(['not in', 'id', $actionNonWinners])->all();

        echo var_dump($participants);
    }
}
