<?php

use common\extension\elgormEx\yii2UploadableCropableImage\src\WidgetEx;
use common\modules\user\models\enum\UserStatusEnum;
use common\modules\user\models\UserModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\UserModel */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-model-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?php if (Yii::$app->user->can('accessOnlyAdmin')): ?>
        <?= $form->field($model, 'role')->dropDownList(UserModel::getListRoles()); ?>

        <?= $form->field($model, 'status')->dropDownList(UserStatusEnum::listData()); ?>
    <?php endif; ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?php if ($model->image) { ?>
        <img src="<?= $model->getImageSource(); ?>" height="120" id="cropper-img-<?= $model->id ?>" />
    <?php } ?>
    <?= $form->field($model, 'image')->widget(WidgetEx::class); ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if ($model->id == Yii::$app->user->identity->id): ?>
        <div class="form-group">
            <?= Html::a('Сменить пароль', ['password-change'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can('accessOnlyAdmin')): ?>
        <div class="form-group">
            <?= Html::a('Сбросить пароль', ['password-flush', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>
</div>
