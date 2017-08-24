<?php

use yii\db\Migration;

class m170824_164933_add_board_id extends Migration
{
    public function up()
    {
        $this->addColumn('resolution', 'board_id', $this->integer());
        $this->addColumn('site_news', 'board_id', $this->integer());
        $this->addColumn('task', 'board_id', $this->integer());

    }

    public function down()
    {
        echo "m170824_164933_add_board_id cannot be reverted.\n";

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
