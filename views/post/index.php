<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'discription:ntext',
            'createad_at',
            [
                'label' => 'Категории',
                'format' => 'raw',
                'value' => function(\app\models\Post $model){

                    $result = '' ;
                    foreach($model->categories  as $category ){
                            $result.=  Html::a($category->name, ['category/view', 'id' => $category->id]);
                            $result.='<br>';
                    }
                    return $result;
                }
            ],
            ['class' => 'yii\grid\ActionColumn','header'=>'Действие'],
        ],
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
    ]); ?>

</div>