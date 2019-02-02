<?php
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
/* @var $relatedModel \skeeks\cms\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('skeeks/cms', 'Tags')); ?>

<?php
echo $form->field($model, 'tagValues')->widget(\dosamigos\selectize\SelectizeTextInput::className(), [
    'loadUrl'       => ['/tag/admin-tag/search'],
    'options'       => ['class' => 'form-control'],
    'clientOptions' => [
        'plugins'     => ['remove_button'],
        'valueField'  => 'name',
        'labelField'  => 'name',
        'searchField' => ['name'],
        'create'      => true,
    ],
])->hint('Tag list')->label('Tags') ?>



<?= $form->fieldSetEnd() ?>
