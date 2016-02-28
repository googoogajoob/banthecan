<?php

use yii\db\Migration;

class m160227_135915_tasks_add_completed extends Migration
{
    public function up()
    {
        $this->addColumn('task', 'completed', $this->boolean());
    }

    public function down()
    {
        echo "m160227_135915_tasks_add_completed cannot be reverted.\n";

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
