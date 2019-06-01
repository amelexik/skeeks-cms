<?php
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
/* @var $relatedModel \skeeks\cms\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('skeeks/cms', 'Announcement')); ?>
<?= $form->field($model, 'image_id')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'accept' => 'image/*',
        'multiple' => false,
        /** BEGIN OF AMELEX CHANGES */
        'additionalFields'=>[
            'name',
            'source'
        ]
        /** END OF AMELEX CHANGES */
    ]
); ?>
<?= $form->field($model, 'description_short')->widget(
    \skeeks\cms\widgets\formInputs\comboText\ComboTextInputWidget::className(),
    [
        'modelAttributeSaveType' => 'description_short_type',
    ]);
?>
<?= $form->fieldSetEnd() ?>
