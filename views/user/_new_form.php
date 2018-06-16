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
        ]
    ); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?php if (Yii::$app->user->can('accessOnlyAdmin')): ?>
        <?= $form->field($model, 'role')->dropDownList(UserModel::getListRoles()); ?>

        <?= $form->field($model, 'status')->dropDownList(UserStatusEnum::listData()); ?>
    <?php endif; ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget(WidgetEx::class); ?>
    <?php if ($model->image) { ?>
        <img src="<?= $model->getImageSource(); ?>" height="120" id="cropper-img-<?= $model->id ?>" />
    <?php } ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
