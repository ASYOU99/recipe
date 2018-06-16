<?php

use app\models\Ingridient;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $form yii\widgets\ActiveForm */
$formId = 'js-dynamic-form';
$new = $model->isNewRecord;
?>

<div class="recipe-form">

    <?php $form = ActiveForm::begin(['id' => $formId]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if ($new): ?>
        <div id="url" class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $resIngrs[0],
                'formId' => $formId,
                'formFields' => [
                    'file',
                    'image',
                ],
            ]); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-envelope"></i> Ингридиенты
                    <button type="button" class="pull-right add-item btn btn-success btn-xs"><i
                                class="fa fa-plus"></i> Добавить игридиент
                    </button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body container-items"><!-- widgetContainer -->
                    <!--                                        <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($resIngrs as $i => $ing): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <span class="panel-title-doc">Игридиент: <?= ($i + 1) ?></span>
                                <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i
                                            class="fa fa-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (!$ing->isNewRecord) {
                                    echo Html::activeHiddenInput($ing, "[{$i}]id");
                                } ?>

                                <?= $form->field($ing, "[{$i}]ing_id")
                                    ->dropDownList(ArrayHelper::map(Ingridient::find()->all(), 'id', 'name'), ['prompt' => '--Выберите ингридиент--']) ?>

                                <?= $form->field($ing, "[{$i}]value")->textInput(['maxlength' => true]) ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-whatever="@getbootstrap">Добавить новый ингридиент
        </button>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Новый игридиент</h4>
            </div>
            <div class="modal-body">
                <?php $formIng = ActiveForm::begin(
                    ['action' => '/ingridient/create']
                ); ?>

                <?= $formIng->field($ingridient, 'name')->textInput(['maxlength' => true]) ?>

                <?= $formIng->field($ingridient, 'recipe')->hiddenInput(['value' => 'true'])->label(false) ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
