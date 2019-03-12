<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PsiteController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionAddmember($email, $password, $role, $lname, $fname, $nickname) {
    	$member = new \app\models\Member;
    	$member->email = $email;
    	$member->setPassword($password);
    	$member->role = $role;
        $member->lname = $lname;
        $member->fname = $fname;
        $member->nickname = $nickname;
        $member->save();
        
    	echo "\nNew member has been created.\n";
    }

    public function actionPopulateMembers(){
        $members = [
            ['bgnmp@yahoo.com','password123',2,'Smith','John','johnny','Quallcomm University','Faculty'],
            ['jndd@yahoo.com', 'password123',2,'Jane','Doe','jenny','University of the Lost', 'Faculty'],
            ['hnkk@gmail.com', 'password123',2,'Tim','Cooke','tim','Industrial University', 'Dean'],
            ['bench@email.com','password123',2,'Benedict','Sanchez','benny','Nerd International College', 'Chairman'],
            ['graziel@email.com','password123',2,'Grace','Michaels','grazie','Bakersfield Institute','Dean'],
            ['rant@email.com','password123',2,'Randall','Trentt','rant','St. Falcon University','Faculty'],
            ['georged@email.com','password123',2,'George','Daniels','george','Western College of Technology','Faculty']
        ];

        foreach($members as $m) {
            $member = new \app\models\Member;
            $member->email = $m[0];
            $member->setPassword($m[1]);
            $member->role = $m[2];
            $member->fname = $m[3];
            $member->lname = $m[4];
            $member->nickname = $m[5];
            $member->school = $m[6];
            $member->designation = $m[7];
            $member->save();
        }
        echo "Done.\n";
    }

    public function actionNonWinners(){

        $winningIds =  (new \yii\db\Query())
                    ->select(['participant_id'])
                    ->from('raffle')
                    ->where(['not', 'drawn IS NULL']);

        $participants = \app\models\Participant::find()
            ->where(['not in', 'id', $winningIds]);

        echo var_dump($participants->all());
    }

    public function actionResetRaffles()
    {
        Yii::$app->db->createCommand('DELETE FROM raffle WHERE 1')
            ->execute();
        echo "Reset Raffles Data Complete.\n";
    }

    public function actionResetElection() 
    {
        echo "Flushing votes..\n";
        Yii::$app->db->createCommand('DELETE FROM vote WHERE 1')->execute();
        echo "Flushing candidates..\n";
        Yii::$app->db->createCommand('DELETE FROM candidate WHERE 1')->execute();
        echo "Deleting election..";
        Yii::$app->db->createCommand('DELETE FROM election WHERE 1')->execute();
        echo "\nElection Reset Complete.\n";
    }
}
