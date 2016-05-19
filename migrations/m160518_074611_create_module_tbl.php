<?php

use yii\db\Schema;
use yii\db\Migration;

class m160518_074611_wishlist extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%wishlist}}',
            [
                'id'=> Schema::TYPE_PK."",
                'user_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                'model'=> Schema::TYPE_STRING."(255) NOT NULL",
                'item_id'=> Schema::TYPE_INTEGER."(11) NOT NULL",
                ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%wishlist}}');
    }
}
