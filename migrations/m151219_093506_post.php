<?php

use yii\db\Schema;
use yii\db\Migration;

class m151219_093506_post extends Migration
{
    public function up()
    {
	$this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
	        'discription' => $this->text()->notNull(),
            'createad_at' => $this->date()->notNull()
        ]);
    }

    public function down()
    {
	$this->dropTable('post');
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
