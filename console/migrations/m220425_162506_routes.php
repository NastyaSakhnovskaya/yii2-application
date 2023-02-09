<?php

use yii\db\Migration;

/**
 * Class m220425_162506_routes
 */
class m220425_162506_routes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('routes', [
            'route_id' => $this->primaryKey(),
            'direction_from' => $this->string(50),
            'direction_to' => $this->string(50),
            'date' => $this->date('Y-m-d H:i:s'),
            'time' => $this->string(10),
            'number_of_free_seats' => $this->integer(),
            'price' => $this->integer(),
            'driver_id' => $this->integer(),
            'bus_id' => $this->integer(),
            'route_status' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220425_162506_routes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220425_162506_routes cannot be reverted.\n";

        return false;
    }
    */
}
