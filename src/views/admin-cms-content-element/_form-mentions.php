<?php
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
/* @var $relatedModel \skeeks\cms\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('skeeks/cms', 'Mentions')); ?>

<?php if ($mentionContent = \skeeks\cms\models\CmsContent::find()->where(['in', 'id', Yii::$app->mention->relatedElementContentIds])->all()) { ?>

    <?php
    $data = (\yii\helpers\ArrayHelper::map(\skeeks\cms\models\CmsContentElement::find()->limit(10)->all(), 'id', 'name'));
    ?>
    <?php foreach ($mentionContent as $content) { ?>
        <div class="form-group">
            <label class="control-label"><?= $content->name; ?></label>
            <?php
            $url = \yii\helpers\Url::to(['/mention/admin-mention/search']) . '?content_id=' . $content->id;
            $data = isset($model->adminMentions[$content->id]) ? $model->adminMentions[$content->id] : [];
//            $selected = [['id'=>1,'value'=>'dsdsd']];

            echo \kartik\select2\Select2::widget([
                'name'          => $model->formName() . '[mentionSuggest][' . $content->id . ']',
                'value' => array_keys($data),
                //'value'         => $selected, // initial value (will be ordered accordingly and pushed to the top)
                'data' => $data,
                'options'       => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear'         => false,
                    'minimumInputLength' => 1,
                    'language'           => [
                        'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax'               => [
                        'url'      => $url,
                        'dataType' => 'json',
                        'data'     => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup'       => new \yii\web\JsExpression('function (markup) { return markup; }'),
                    'templateResult'     => new \yii\web\JsExpression('function(city) { return city.text; }'),
                    'templateSelection'  => new \yii\web\JsExpression('function (city) { return city.text; }'),
                ],
            ]);

            ?>
        </div>
    <?php } ?>
<?php } ?>



<?= $form->fieldSetEnd() ?>
