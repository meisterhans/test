<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Utils;
use app\models\Companies;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Admin panel';


?>
<div class="site-index">

    <div class="body-content">

        <div class="nav-tabs-custom">
            <div class="tab-pane" id="statistics">
                <div class="box-header">
                    <div class="grid-view-buttons">
                        <?= Html::a("Сгенерировать", "#nogo", ['class' => 'btn btn-success generate']) ?>
                    </div>
                </div>
                <div id="users_form">
                    <?= GridView::widget([
                        'dataProvider' => $data,
                        'summary' => "",
                        'tableOptions' => ['class' => 'table table-bordered table-hover'],
                        'columns' => [
                            'user_name',
                            'resource',
                            [
                                'attribute' => 'created_at',
                                'value' => function($data){
                                    return Yii::$app->formatter->asDate($data->created_at, 'php:Y-m-d H:i:s');
                                }
                            ],
                            [
                                'attribute' => 'total',
                                'value' => function($data){
                                    return Utils::formatQuota($data->amount);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

    </div>
</div>
