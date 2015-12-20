<?php

use yii\db\Schema;
use yii\db\Migration;

class m151220_153349_coments extends Migration
{
    public function up()
    {
        $this->createTable('coments', [
            'post_id' => $this->integer(),
            'description' => $this->text(),
        ]);
        $this->addForeignKey("fk_coments", "coments", "post_id", "post", "id");
    }

    public function down()
    {
        $this->dropTable("coments");
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
