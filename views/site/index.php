<?php

/** @var yii\web\View $this */

use yii\widgets\LinkPager;

$this->title = 'Главная';
?>
<div class="site-index row">
    <div class="col-sm-12">
        <h1>Книги</h1>
    </div>

    <?php if (\Yii::$app->request->get('author')){
        echo '<div class="col-sm-12"><p><a href="/index">Сбросить</a> </p></div>';
    } ?>
<?php
    foreach ($models as $model) {
        echo '<div class="col-sm-12 border"> <h1 class="align-content-center">'.$model['name'].'</h1><h6><a href="/index?author='.$model['author_id'].'">'.$model['fio'].'</a></h6></div> ';
    }

    // отображаем постраничную разбивку
    echo '<div class="pagination">'.LinkPager::widget([
        'pagination' => $pages,
        'registerLinkTags' => true
    ]).'<div>';
?>

</div>
