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
            <ul class="nav nav-tabs">
                <li class="active"><a href="#companies" data-toggle="tab">Компании</a></li>
                <li><a href="#users" data-toggle="tab">Пользователи</a></li>
                <li><a href="#statistics" data-toggle="tab">Статистика</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="companies">
                    <div class="box-header">
                        <div class="grid-view-buttons">
                            <?= Html::a("Добавить", "#nogo", ['class' => 'btn btn-success action-button']) ?>
                        </div>
                    </div>
                    <?php Pjax::begin();?>
                    <div class="form" id="companies_form">
                        <?php $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => '/companies'
                        ]);?>
                            <?= $form->field($companies_model, 'name')->textInput(['name' => 'name']) ?>
                            <div class="quota">
                                <div class="left">
                                    <?= $form->field($companies_model, 'quota')->textInput(['name' => 'quota']) ?>
                                </div>
                                <div class="right">
                                    <?= $form->field($companies_model, 'quota_type')->dropDownList([
                                        Companies::MB => "MB",
                                        Companies::GB => "GB",
                                        Companies::TB => "TB"
                                    ], ['name' => 'quota_type']); ?>
                                </div>
                            </div>

                            <div class="form-group clear">
                                <?= Html::submitButton("Сохранить", ['class' => 'btn btn-success']) ?>
                                <?= Html::a("Отмена", "#nogo", ['class' => 'btn btn-success action-cancel']) ?>
                            </div>
                        <?php ActiveForm::end();?>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $companies,
                        'summary' => "",
                        'tableOptions' => ['class' => 'table table-bordered table-hover'],
                        'columns' => [
                            'name',
                            [
                                'attribute' => 'quota',
                                'value' => function($data){
                                    return Utils::formatQuota($data->quota);
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a( '<span class="glyphicon glyphicon-trash"></span>', ['/companies/delete', 'id' => $model->id],
                                            [
                                                'data' => [
                                                    'confirm' => 'Удалить?',
                                                    'method' => 'delete',
                                                ],
                                                'onclick' => 'setTimeout(function(){$.pjax.reload({container: "#p0", async:true});}, 1000);'
                                            ]
                                        );
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', "#nogo", [
                                            'class' => 'update-company',
                                            'id' => $model->id
                                        ]);
                                    }
                                ],
                                'template' => '{update} {delete}',
                                'contentOptions'=>['style'=>'width: 60px; text-align:center;'],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end();?>
                </div>
                <div class="tab-pane" id="users">
                    <div class="box-header">
                        <div class="grid-view-buttons">
                            <?= Html::a("Добавить", "#nogo", ['class' => 'btn btn-success action-button']) ?>
                        </div>
                    </div>
                    <?php Pjax::begin();?>
                    <div class="form" id="users_form">
                        <?php $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => '/users'
                        ]);?>
                        <?= $form->field($users_model, 'company_id')->dropDownList(\yii\helpers\ArrayHelper::map(Companies::getAllCompanies(), 'id', 'name'), ['name' => 'company_id']); ?>

                        <?= $form->field($users_model, 'name')->textInput(['name' => 'name']) ?>
                        <?= $form->field($users_model, 'email')->textInput(['name' => 'email']) ?>

                        <div class="form-group clear">
                            <?= Html::submitButton("Сохранить", ['class' => 'btn btn-success']) ?>
                            <?= Html::a("Отмена", "#nogo", ['class' => 'btn btn-success action-cancel']) ?>
                        </div>
                        <?php ActiveForm::end();?>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $users,
                        'summary' => "",
                        'tableOptions' => ['class' => 'table table-bordered table-hover'],
                        'columns' => [
                            [
                                'attribute' => 'company_id',
                                'value' => function($data) {
                                    return $data->company_name;
                                }
                            ],
                            'name',
                            'email',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a( '<span class="glyphicon glyphicon-trash"></span>', ['/users/delete', 'id' => $model->id],
                                            [
                                                'data' => [
                                                    'confirm' => 'Удалить?',
                                                    'method' => 'delete',
                                                ],
                                                'onclick' => 'setTimeout(function(){$.pjax.reload({container: "#p1", async:true});}, 1000);'
                                            ]
                                        );
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', "#nogo", [
                                            'class' => 'update-user',
                                            'id' => $model->id,
                                            'company_id' => $model->company_id,
                                        ]);
                                    }
                                ],
                                'template' => '{update} {delete}',
                                'contentOptions'=>['style'=>'width: 60px; text-align:center;'],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end();?>
                </div>
                <div class="tab-pane" id="statistics">
                    <div class="box-header">
                        <div class="grid-view-buttons">
                            <?= Html::a("Сгенерировать", "#nogo", ['class' => 'btn btn-success generate']) ?>
                        </div>
                    </div>
                    <?php Pjax::begin();?>
                    <div id="users_form">
                        <?= GridView::widget([
                            'dataProvider' => $data,
                            'summary' => "",
                            'tableOptions' => ['class' => 'table table-bordered table-hover'],
                            'columns' => [
                                [
                                    'attribute' => 'company_name',
                                    'format' => 'html',
                                    'value' => function($data){
                                        return Html::a($data->company_name, ['/site/company/' . $data->company_id]);
                                    }
                                ],
                                [
                                    'attribute' => 'total',
                                    'value' => function($data){
                                        return Utils::formatQuota($data->total);
                                    }
                                ],
                                [
                                    'attribute' => 'company_quota',
                                    'value' => function($data){
                                        return Utils::formatQuota($data->company_quota);
                                    }
                                ]
                            ],
                        ]); ?>
                    </div>
                    <?php Pjax::end();?>
                </div>
            </div>
        </div>

    </div>
</div>
