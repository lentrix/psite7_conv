<?php

use yii\db\Migration;

/**
 * Handles the creation of table `participant`.
 */
class m180208_091034_create_participant_table extends Migration
{
    public function up()
    {
       $this->createTable('participant', [
            'id' => $this->primaryKey(),
            'member_id' => $this->integer()->notNull(),
            'convention_id' => $this->integer()->notNull(),
            'room_id' => $this->integer(),
            'role'=>$this->string(45)->defaultValue('delegate'),
            'has_voted' => $this->boolean()->defaultValue(0),
            'eligible' => $this->boolean()->defaultValue(0),
            'nominated' => $this->boolean()->defaultValue(0)
        ]);

        $this->createIndex(
            'idx-participant-member_id',
            'participant',
            'member_id'
        );

        $this->addForeignKey(
            'fk-participant-member',
            'participant',
            'member_id',
            'members',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-participant-convention_id',
            'participant',
            'convention_id'
        );

        $this->addForeignKey(
            'fk-participant-convention',
            'participant',
            'convention_id',
            'convention',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-participant-room_id',
            'participant',
            'room_id'
        );

        $this->addForeignKey(
            'fk-participant-room',
            'participant',
            'room_id',
            'room',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-participant-member','participant');
        $this->dropIndex('idx-participant-member_id', 'participant');
        $this->dropForeignKey('fk-participant-convention','participant');
        $this->dropIndex('idx-participant-convention_id', 'participant');
        $this->dropForeignKey('fk-participant-room','participant');
        $this->dropIndex('idx-participant-room_id', 'participant');
        $this->dropTable('participant');
    }
}
