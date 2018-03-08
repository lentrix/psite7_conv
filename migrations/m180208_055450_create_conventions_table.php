<?php

use yii\db\Migration;

/**
 * Handles the creation of table `conventions`.
 */
class m180208_055450_create_conventions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('convention', [
            'id' => $this->primaryKey(),
            'series'=>$this->string(10)->notNull(),
            'date_start' => $this->date()->notNull(),
            'date_end' => $this->date()->notNull(),
            'venue' => $this->string()->notNull(),
            'host_school' => $this->string()->notNull(),
            'chair' => $this->string()->notNull(),
            'active' => $this->boolean()->defaultValue(false),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('convention');
    }
}
