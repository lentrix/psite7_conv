<?php

use yii\db\Migration;

/**
 * Handles the creation of table `room`.
 */
class m180208_090248_create_room_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('room', [
            'id' => $this->primaryKey(),
            'convention_id' => $this->integer()->notNull(),
            'name' => $this->string(45)->notNull(),
            'capacity'=>$this->smallinteger()->notNull(),
            'occupants'=>$this->smallinteger()->defaultValue(0)
        ]);

        $this->createIndex('idx-room-convention_id','room','convention_id');
        $this->addForeignKey(
            'fk-room-convention', 
            'room',
            'convention_id',
            'convention',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-room-convention','room');
        $this->dropIndex('idx-room-convention_id','room');
        $this->dropTable('room');
    }
}
