<?php

use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use yii\helpers\Html;

/* @var $model \skeeks\cms\models\CmsContentElement */
/* @var $relatedModel \skeeks\cms\relatedProperties\models\RelatedPropertiesModel */

/* @var $this yii\web\View */
/* @var $controller \skeeks\cms\backend\controllers\BackendModelController */
/* @var $action \skeeks\cms\backend\actions\BackendModelCreateAction|\skeeks\cms\backend\actions\IHasActiveForm */
/* @var $model \skeeks\cms\models\CmsLang */
$controller = $this->context;
$action = $controller->action;

if ($model->isNewRecord) {
    if ($tree_id = \Yii::$app->request->get("tree_id")) {
        $model->tree_id = $tree_id;
    }

    if ($parent_content_element_id = \Yii::$app->request->get("parent_content_element_id")) {
        $model->parent_content_element_id = $parent_content_element_id;
    }
}
?>
<? if (!$model->isNewRecord) : ?>
    <div class="sx-box sx-p-10 sx-bg-primary" style="margin-bottom: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <?php /** BEGIN OF AMELEX CHANGES */ ?>
                    <a rel="noopener noreferrer" href=https://danilin.biz/clear-share-cache.htm' target='_blank'
                                                              class="btn btn-default btn-sm">How to clear cache? <i
                                class="glyphicon glyphicon-arrow-right"></i></a>

                    <a href='https://developers.facebook.com/tools/debug/sharing/?q=<?= $model->absoluteUrl; ?>'
                       target='_blank' class="btn btn-default btn-sm">Facebook cache <i
                                class="glyphicon glyphicon-refresh"></i></a>

                    <a href='https://cards-dev.twitter.com/validator' target='_blank' class="btn btn-default btn-sm">Twitter
                        cache <i class="fa fa-user"></i></a>

                    <a href='https://t.me/previews' target='_blank' class="btn btn-default btn-sm">Telegram cache <i
                                class="glyphicon glyphicon-refresh"></i></a>
                    <?php /** END OF AMELEX CHANGES */ ?>

                    <a href='<?= $model->url; ?>' target='_blank' class="btn btn-default btn-sm"
                       title="<?= \Yii::t('skeeks/cms', 'Watch to site (opens new window)'); ?>">Watch to site <i
                                class="glyphicon glyphicon-arrow-right"></i></a>
                </div>

            </div>
        </div>
    </div>
<? endif; ?>


<?php $form = $action->beginActiveForm([
    'id'                     => 'sx-dynamic-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
]); ?>
<?php $this->registerJs(<<<JS

(function(sx, $, _)
{
    sx.classes.DynamicForm = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $("[data-form-reload=true]").on('change', function()
            {
                self.update();
            });
        },

        update: function()
        {
            _.delay(function()
            {
                var jForm = $("#sx-dynamic-form");
                jForm.append($('<input>', {'type': 'hidden', 'name' : 'sx-not-submit', 'value': 'true'}));
                jForm.submit();
            }, 200);
        }
    });

    sx.DynamicForm = new sx.classes.DynamicForm();
})(sx, sx.$, sx._);


JS
); ?>



<?php echo $form->errorSummary([$model, $relatedModel]); ?>
<div style="display: none;">

    <?php if ($model->isNewRecord) : ?>
        <?php if ($content_id = \Yii::$app->request->get("content_id")) : ?>
            <?php $contentModel = \skeeks\cms\models\CmsContent::findOne($content_id); ?>
            <?php $model->content_id = $content_id; ?>
            <?= $form->field($model, 'content_id')->hiddenInput(['value' => $content_id])->label(false); ?>
        <?php endif; ?>
    <?php else
        : ?>
        <?php $contentModel = $model->cmsContent;
        ?>
    <?php endif; ?>

    <?php if ($contentModel && $contentModel->parentContent) : ?>
        <?= Html::activeHiddenInput($contentModel, 'parent_content_is_required'); ?>
    <?php endif; ?>
</div>

<?= $this->render('_form-main', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>

<?= $this->render('_form-announce', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>

<?= $this->render('_form-detail', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>

<?= $this->render('_form-sections', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>

<?= $this->render('_form-seo', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>

<?= $this->render('_form-images', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>

<?= $this->render('_form-additionaly', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>

<?= $this->render('@skeeks/cms/tag/views/_form-tags', [
    'form'         => $form,
    'contentModel' => $contentModel,
    'model'        => $model,
]); ?>


<?php
if (\skeeks\cms\models\CmsContent::find()->where(['in', 'id', Yii::$app->mention->relatedElementContentIds])->count())
    echo $this->render('@skeeks/cms/mention/views/_form-mentions', [
        'form'         => $form,
        'contentModel' => $contentModel,
        'model'        => $model,
    ]);
?>




<?php if (!$model->isNewRecord) : ?>
    <?php if ($model->cmsContent->access_check_element == "Y") : ?>
        <?= $form->fieldSet(\Yii::t('skeeks/cms', 'Access')); ?>
        <?= \skeeks\cms\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
            'permissionName'        => $model->permissionName,
            'permissionDescription' => 'Доступ к этому элементу: ' . $model->name,
            'label'                 => 'Доступ к этому элементу',
        ]); ?>
        <?= $form->fieldSetEnd() ?>
    <?php endif; ?>
<?php endif; ?>

<?php if ($model->cmsContent->childrenContents) : ?>

    <?

    /**
     * @var $content \skeeks\cms\models\CmsContent
     */
    ?>
    <?php foreach ($model->cmsContent->childrenContents as $childContent) : ?>
        <?= $form->fieldSet($childContent->name); ?>

        <?php if ($model->isNewRecord) : ?>

            <?= \yii\bootstrap\Alert::widget([
                'options' =>
                    [
                        'class' => 'alert-warning',
                    ],
                'body'    => \Yii::t('skeeks/cms', 'Management will be available after saving'),
            ]); ?>
        <?php else
            : ?>
            <?= \skeeks\cms\modules\admin\widgets\RelatedModelsGrid::widget([
                'label'       => $childContent->name,
                'namespace'   => md5($model->className() . $childContent->id),
                'parentModel' => $model,
                'relation'    => [
                    'content_id'                => $childContent->id,
                    'parent_content_element_id' => $model->id,
                ],

                'sort' => [
                    'defaultOrder' =>
                        [
                            'priority' => 'published_at',
                        ],
                ],

                'controllerRoute' => '/cms/admin-cms-content-element',
                'gridViewOptions' => [
                    'columns' => (array)\skeeks\cms\controllers\AdminCmsContentElementController::getColumns($childContent),
                ],
            ]);
            ?>

        <?php endif; ?>




        <?= $form->fieldSetEnd() ?>
    <?php endforeach; ?>
<?php endif; ?>



<?= $form->buttonsStandart($model); ?>
<?php echo $form->errorSummary([$model, $relatedModel]); ?>
<?php ActiveForm::end(); ?>
