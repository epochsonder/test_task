<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\LinkAuthorBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="link-author-book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author')->dropDownList(ArrayHelper::map(\app\modules\admin\models\Author::find()->all(), 'id', 'fio')) ?>

    <?php if($create) {
        echo    $form->field($model, 'book')->dropDownList($books);
    } else{
        echo $form->field($model, 'book')->dropDownList(ArrayHelper::map(\app\modules\admin\models\Book::find()->all(), 'id', 'name'));
    } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
