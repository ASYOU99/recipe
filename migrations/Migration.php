<?php

namespace app\migrations;

use Yii;

class Migration extends \yii\db\Migration
{

    protected $tableOptions;


    public function init()
    {
        parent::init();
        $this->tableOptions = null;
        if (Yii::$app->db->driverName == 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }
}