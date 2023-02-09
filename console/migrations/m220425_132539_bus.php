<?php

use yii\db\Migration;

/**
 * Class m220425_132539_bus
 */
class m220425_132539_bus extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bus', [
            'bus_id' => $this->primaryKey(),
            'bus_number' => $this->string(50),
            'brand' => $this->string(50),
            'color' => $this->string(50),
            'number_of_seats' => $this->integer(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220425_132539_bus cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220425_132539_bus cannot be reverted.\n";

        return false;
    }
    */
}
