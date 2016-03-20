<?php

use yii\db\Migration;

class m160320_221138_decoration_data extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'decoration_data', $this->text());
    }

    public function down()
    {
        echo "m160320_221138_decoration_data cannot be reverted.\n";

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
