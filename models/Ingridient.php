<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingridient".
 *
 * @property int $id
 * @property string $name
 *
 * @property RecIng[] $recIngs
 */
class Ingridient extends \yii\db\ActiveRecord
{
    public $recipe = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingridient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['recipe'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecIngs()
    {
        return $this->hasMany(RecIng::className(), ['ing_id' => 'id']);
    }
}
