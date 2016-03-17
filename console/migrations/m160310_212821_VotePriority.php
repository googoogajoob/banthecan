<?php

use yii\db\Migration;

class m160310_212821_VotePriority extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'vote_priority', $this->integer());
    }

    public function down()
    {
        echo "m160310_212821_VotePriority cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
