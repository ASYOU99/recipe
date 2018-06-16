<?php

use app\migrations\Migration;


/**
 * Handles the creation of table `recipe`.
 */
class m180616_145745_create_recipe_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('recipe', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'description' => $this->text(),
            'user_id' => $this->integer(),
        ], $this->tableOptions);

        $this->createIndex(
            'idx-recipe-user_id',
            'recipe',
            'user_id'
        );

        $this->addForeignKey(
            'fk-recipe-user_id',
            'recipe',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('recipe');
    }
}
