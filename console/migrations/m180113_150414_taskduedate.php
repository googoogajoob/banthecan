<?php

use yii\db\Migration;

class m180113_150414_taskduedate extends Migration
{
    public function up()
    {
        $this->addColumn('task', 'due_date', $this->integer());

    }

    public function down()
    {
        echo "m180113_150414_taskduedate cannot be reverted.\n";

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
