<?php

use yii\db\Migration;

/**
 * Handles the creation of table `raffle`.
 */
class m180324_051847_create_raffle_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('raffle', [
            'id' => $this->primaryKey(),
            'created' => $this->timestamp(),
            'created_by' => $this->integer()->notNull(),
            'convention_id' => $this->integer()->notNull(),
            'prize' => $this->string(90)->notNull(),
            'participant_id' => $this->integer(),
            'drawn' => $this->dateTime()

        ]);

        $this->createIndex(
            'idx-raffle-created_by',
            'raffle',
            'created_by'
        );
        $this->addForeignKey(
            'fk-raffle-creator',
            'raffle',
            'created_by',
            'members',
            'id'
        );

        $this->createIndex(
            'idx-raffle-convention_id',
            'raffle',
            'convention_id'
        );
        $this->addForeignKey(
            'fk-raffle-convention',
            'raffle',
            'convention_id',
            'convention',
            'id'
        );

        $this->createIndex(
            'idx-raffle-participant_id',
            'raffle',
            'participant_id'
        );
        $this->addForeignKey(
            'fk-raffle-participant',
            'raffle',
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
        $this->dropForeignKey('fk-raffle-convention','raffle');
        $this->dropForeignKey('fk-raffle-participant','raffle');
        $this->dropForeignKey('fk-raffle-creator', 'raffle');
        $this->dropIndex('idx-raffle-convention_id', 'raffle');
        $this->dropIndex('idx-raffle-participant_id', 'raffle');
        $this->dropIndex('idx-raffle-created_by', 'raffle');

        $this->dropTable('raffle');
    }
}
