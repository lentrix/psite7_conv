<?php

use yii\db\Migration;

/**
 * Handles the creation of table `election`.
 */
class m180305_132038_create_election_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('election', [
            'id' => $this->primaryKey(),
            'convention_id'=>$this->integer()->notNull(),
            'election_officer'=>$this->string(100)->notNull(),
            'no_of_winners'=>$this->integer(1)->defaultValue(1),
            'status'=>$this->integer(1)->defaultValue(0),
            'start'=>$this->dateTime(),
            'started_by'=>$this->integer(),
            'end' => $this->dateTime(),
            'ended_by' => $this->integer()
        ]);

        $this->createIndex(
            'idx-election-started_by',
            'election',
            'started_by'
        );

        $this->addForeignKey(
            'fk-election-starter',
            'election',
            'started_by',
            'members',
            'id'
        );

        $this->createIndex(
            'idx-election-ended_by',
            'election',
            'ended_by'
        );

        $this->addForeignKey(
            'fk-election-ender',
            'election',
            'ended_by',
            'members',
            'id'
        );

        $this->createIndex(
            'idx-election-convention_id',
            'election',
            'convention_id'
        );

        $this->addForeignKey(
            'fk-election-convention',
            'election',
            'convention_id',
            'convention',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-election-starter', 'election');
        $this->dropForeignKey('fk-election-ender', 'election');
        $this->dropIndex('idx-election-started_by', 'election');
        $this->dropIndex('idx-election-ended_by', 'election');
        $this->dropForeignKey('fk-election-convention', 'election');
        $this->dropIndex('idx-election-convention_id', 'election');
        $this->dropTable('election');
    }
}
