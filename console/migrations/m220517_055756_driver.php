<?php

use yii\db\Migration;

/**
 * Class m220517_055756_driver
 */
class m220517_055756_driver extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('driver', [
            'driver_id' => $this->primaryKey(),
            'driver_name' => $this->string(50),
            'driver_surname' => $this->string(50),
            'phone' => $this->string(50),
            'driver_login' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220517_055756_driver cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220517_055756_driver cannot be reverted.\n";

        return false;
    }
    */
}
