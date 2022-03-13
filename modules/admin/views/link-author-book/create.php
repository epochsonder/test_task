<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\LinkAuthorBook */

$this->title = 'Создание связи';
$this->params['breadcrumbs'][] = ['label' => 'Link Author Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-author-book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'books' => $books,
        'create' => 1,
    ]) ?>

</div>
