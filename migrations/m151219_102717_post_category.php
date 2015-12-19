<?php

use yii\db\Schema;
use yii\db\Migration;

class m151219_102717_post_category extends Migration
{
    public function up()
    {
        $this->createTable('post_category', [
            'post_id' => $this->integer(),
            'category_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_post_category', 'post_category', ['post_id', 'category_id']);

        $this->addForeignKey("fk_post_category", "post_category", "category_id", "category", "id");
        $this->addForeignKey("fk_category_post", "post_category", "post_id", "post", "id");
    }

    public function down()
    {
        $this->dropTable("post_category");
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
