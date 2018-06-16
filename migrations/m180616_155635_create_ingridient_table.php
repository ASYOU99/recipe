<?php

use app\migrations\Migration;


/**
 * Handles the creation of table `ingridient`.
 */
class m180616_155635_create_ingridient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ingridient', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ingridient');
    }
}
