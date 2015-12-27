<?php

use yii\db\Schema;
use yii\db\Migration;

class m151227_113400_user extends Migration
{
    public function up()
    {

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(20),
            'password_hash' => $this->string(200),
            'created_at' => $this->integer(),
            'status' => $this->smallInteger(1)
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
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
