<?php

use yii\db\Migration;

class m160118_193925_add_ticket_protocol_field extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'protocol', $this->text());
    }

    public function down()
    {
        echo "m160118_193925_add_ticket_protocol_fieldcannot be reverted.\n";
        return false;
    }
    /*
    // Use safeUp/safeDown to run
        migration code within a transaction
    public function safeUp()
    {
    }

    publicfunction safeDown()
    {
    } */
}
