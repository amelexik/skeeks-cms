<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 14.10.2015
 */
$model = new \skeeks\cms\models\CmsContentElement();
?>
<?php $form = \skeeks\cms\modules\admin\widgets\ActiveForm::begin(); ?>

<?php /*= $form->field($model, 'treeIds')->widget(
        \skeeks\cms\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
        [
            'multiple' => true
        ]
    ); */ ?>

<?= $form->field($model, 'treeIds')->widget(
    \skeeks\cms\backend\widgets\SelectModelDialogTreeWidget::class,
    [
        'multiple' => true
    ]
); ?>


<?= \yii\helpers\Html::checkbox('removeCurrent', false); ?> <label><?= \Yii::t('skeeks/cms',
        'Get rid of the already linked (in this case, the selected records bind only to the selected section)') ?></label>
<?= $form->buttonsStandart($model, ['save']); ?>

<?php \skeeks\cms\modules\admin\widgets\ActiveForm::end(); ?>


<?php \yii\bootstrap\Alert::begin([
    'options' => [
        'class' => 'alert-info',
        'style' => 'margin-top: 20px;',
    ],
]) ?>
    <p><?= \Yii::t('skeeks/cms', 'You can specify some additional sections that will show your records.') ?></p>
    <p><?= \Yii::t('skeeks/cms', 'This does not affect the final address of the page, and hence safe.') ?></p>
<?php \yii\bootstrap\Alert::end(); ?>