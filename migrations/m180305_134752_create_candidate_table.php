<?php

use yii\db\Migration;

/**
 * Handles the creation of table `candidate`.
 */
class m180305_134752_create_candidate_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('candidate', [
            'id' => $this->primaryKey(),
            'election_id'=>$this->integer()->notNull(),
            'participant_id'=>$this->integer()->notNull(),
            'remarks'=>$this->string(45)
        ]);

        $this->createIndex(
            'idx-candidate-election_id',
            'candidate',
            'election_id'
        );
        $this->createIndex(
            'idx-candidate-participant_id',
            'candidate',
            'participant_id'
        );

        $this->addForeignKey(
            'fk-candidate-election',
            'candidate',
            'election_id',
            'election',
            'id'
        );
        $this->addForeignKey(
            'fk-candidate-participant',
            'candidate',
            'participant_id',
            'participant',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-candidate-election', 'candidate');
        $this->dropForeignKey('fk-candidate-participant', 'candidate');
        $this->dropIndex('idx-candidate-participant_id', 'candidate');
        $this->dropIndex('idx-candidate-election_id', 'candidate');
        $this->dropTable('candidate');
    }
}
