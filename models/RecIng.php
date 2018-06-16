<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rec_ing".
 *
 * @property int $id
 * @property int $res_id
 * @property int $ing_id
 * @property string $value
 *
 * @property Ingridient $ing
 * @property Recipe $res
 */
class RecIng extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rec_ing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['res_id', 'ing_id'], 'integer'],
            [['value'], 'string'],
            [['ing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingridient::className(), 'targetAttribute' => ['ing_id' => 'id']],
            [['res_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['res_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_id' => 'Рецепт',
            'ing_id' => 'Ингридиент',
            'value' => 'Значение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIng()
    {
        return $this->hasOne(Ingridient::className(), ['id' => 'ing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRes()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'res_id']);
    }
}
