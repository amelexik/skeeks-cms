<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 27.04.2017
 */
namespace skeeks\cms\widgets\assets;
use dosamigos\fileupload\FileUpload;
use dosamigos\fileupload\FileUploadAsset;
use dosamigos\fileupload\FileUploadPlusAsset;
use \yii\web\AssetBundle;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class AjaxFileUploadWidgetAsset
 *
 * @package skeeks\yii2\ajaxfileupload\widgets\assets
 */
class AjaxFileUploadWidgetAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/widgets/assets/src';

    public $css = [
        'css/ajax-file-upload.css'
    ];

    public $js = [
        'js/ajax-file-upload.js',
        'js/ajax-file-upload-tool.js',
        'js/ajax-file-upload-file.js',
        'js/tools/tool-remote-upload.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'skeeks\sx\assets\Core',
    ];

    public function init(){
        parent::init();
        // костыль , отключил бандл - который подключался какогото фига
        \Yii::$app->assetManager->bundles['skeeks\yii2\ajaxfileupload\widgets\assets\AjaxFileUploadWidgetAsset'] = false;
    }

    /**
     * @param string $asset
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    static public function getAssetUrl($asset)
    {
        return \Yii::$app->assetManager->getAssetUrl(\Yii::$app->assetManager->getBundle(static::className()), $asset);
    }
}