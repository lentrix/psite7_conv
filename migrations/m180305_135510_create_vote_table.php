<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vote`.
 */
class m180305_135510_create_vote_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('vote', [
            'id' => $this->primaryKey(),
            'participant_id'=>$this->integer()->notNull(),
            'candidate_id'=>$this->integer()->notNull(),
        ]);

        $this->createIndex('idx-vote-participant_id','vote','participant_id');
        $this->createIndex('idx-vote-candidate_id','vote','candidate_id');

        $this->addForeignKey('fk-vote-participant','vote','participant_id','participant','id');
        $this->addForeignKey('fk-vote-candidate','vote','candidate_id','candidate','id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-vote-candidate','vote');
        $this->dropForeignKey('fk-vote-participant','vote');
        $this->dropIndex('idx-vote-candidate_id', 'vote');
        $this->dropIndex('idx-vote-participant_id', 'vote');
        $this->dropTable('vote');
    }
}
