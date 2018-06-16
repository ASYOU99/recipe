<?php

use app\migrations\Migration;


/**
 * Handles the creation of table `rec_ing`.
 */
class m180616_155650_create_rec_ing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rec_ing', [
            'id' => $this->primaryKey(),
            'res_id' => $this->integer(11),
            'ing_id' => $this->integer(11),
            'value' => $this->text(),
        ], $this->tableOptions);


        $this->createIndex(
            'idx-rec_ing-res_id',
            'rec_ing',
            'res_id'
        );

        $this->addForeignKey(
            'fk-rec_ing-res_id',
            'rec_ing',
            'res_id',
            'recipe',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-rec_ing-ing_id',
            'rec_ing',
            'ing_id'
        );

        $this->addForeignKey(
            'fk-rec_ing-ing_id',
            'rec_ing',
            'ing_id',
            'ingridient',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-rec_ing-ing_id',
            'rec_ing'
        );


        $this->dropIndex(
            'idx-rec_ing-ing_id',
            'rec_ing'
        );


        $this->dropForeignKey(
            'fk-rec_ing-res_id',
            'rec_ing'
        );


        $this->dropIndex(
            'idx-rec_ing-res_id',
            'rec_ing'
        );

        $this->dropTable('rec_ing');
    }
}
