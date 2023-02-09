<?php

use yii\db\Migration;

/**
 * Class m220511_163254_order
 */
class m220511_163254_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'order_id' => $this->primaryKey(),
            'user_id' => $this->string(50),
            'route_id' => $this->integer(),
            'surname' => $this->string(50),
            'name' => $this->string(50),
            'phone' => $this->string(50),
            'number_of_seats' => $this->integer(),
            'status' => $this->string(10),
            'route_id' => $this->integer(),
            'route_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220511_163254_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220511_163254_order cannot be reverted.\n";

        return false;
    }
    */
}
