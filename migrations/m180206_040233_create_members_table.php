<?php

use yii\db\Migration;

/**
 * Handles the creation of table `members`.
 */
class m180206_040233_create_members_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('members', [
            'id'            => $this->primaryKey(),
            'lname'         => $this->string(45)->notNull(),
            'fname'         => $this->string(45)->notNull(),
            'nickname'      => $this->string(25)->notNull(),
            'email'         => $this->string()->unique()->notNull(),
            'password'      => $this->string()->notNull(), 
            'school'        => $this->string(191),
            'designation'   => $this->string(45),
            'phone'         => $this->string(15),
            'authKey'       => $this->string(45),
            'role'          => $this->integer()->defaultValue(2),
            'active'        => $this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('members');
    }
}
