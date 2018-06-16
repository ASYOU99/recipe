<?php

use common\modules\user\models\enum\UserStatusEnum;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\user\models\UserModel;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\UserSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'emptyText' => 'Результатов не найдено.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'uploadUrl',
                'format' => 'raw',
                'value' => function ($data) {
                return Html::img($data->getImageSource(), ['class' => 'img-circle', 'style' => 'width: 100px; height: 100px;']);
                },
            ],

            'username',
            'email:email',
            [
                'attribute' => 'role',
                'filter' => UserModel::getListRoles(),
                'value' => function ($data) {
                    return UserModel::getRoleName($data->role);
                },
            ],

            [
                'attribute' => 'createdAt',
                'format' => ['date', 'php:d-m-Y H:i:s'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'createdAt',
                    'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => ['class' => 'form-control'],
                ]),
            ],
            [
                'attribute' => 'updatedAt',
                'format' => ['date', 'php:d-m-Y H:i:s'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updatedAt',
                    'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => ['class' => 'form-control'],
                ]),
            ],
            [
                'attribute' => 'status',
                'filter' => UserStatusEnum::listData(),
                'value' => function ($model) {
                    return UserStatusEnum::get($model->status);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 60px'],
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return ($model->id != Yii::$app->user->getId()) && !$model->isSuperUser();
                    },
                    'update' => function ($model, $key, $index) {
                        return ($model->id != Yii::$app->user->getId());//TODO::Сделать апдейт для всех кроме админа
                    }

                ]
            ],
        ],
    ]);
    ?>
</div>
