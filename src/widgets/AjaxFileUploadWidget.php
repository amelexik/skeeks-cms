<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 04.05.2017
 */

namespace skeeks\cms\widgets;

use skeeks\cms\models\CmsStorageFile;
use yii\helpers\Html;

/**
 * Class AjaxFileUploadWidget
 * @package skeeks\cms\widgets
 */
class AjaxFileUploadWidget extends \skeeks\yii2\ajaxfileupload\widgets\AjaxFileUploadWidget
{

    public $itemOptions = [
        'tag'   => 'div',
        'class' => 'sx-file col-md-3',
    ];
    public $view_file        = '@skeeks/cms/widgets/views/default';
    /* дополнительные поля для редактирования */
    public $additionalFields = [];

    public function init(){
        parent::init();
        $additionalFieldsBlank = [];
        if($this->additionalFields){
            $file = new CmsStorageFile();
            foreach ($this->additionalFields as $field){
                if($file->canGetProperty($field)){
                    $additionalFieldsBlank[$field] = [
                        'label'=> $file->attributeLabels()[$field],
                        'value'=> '',
                    ];
                }

            }
        }
        $this->clientOptions['defaultOptions']['additionalFields'] = $additionalFieldsBlank;
    }

    protected function _initClientFiles()
    {
        if ($this->multiple) {
            if (is_array($this->model->{$this->attribute})) {
                foreach ($this->model->{$this->attribute} as $value) {
                    if ($file = CmsStorageFile::findOne((int)$value)) {
                        $this->clientOptions['files'][] = $this->_getCmsFileData($file);
                    } else {
                        if ($this->_getClientFileData($value)) {
                            $this->clientOptions['files'][] = $this->_getClientFileData($value);
                        }
                    }
                }

            }

        } else {
            if ($value = $this->model->{$this->attribute}) {
                if ($file = CmsStorageFile::findOne((int)$value)) {
                    $this->clientOptions['files'][] = $this->_getCmsFileData($file);
                } else {
                    return parent::_initClientFiles();
                }
            } else {
                return parent::_initClientFiles();
            }
        }

        return $this;
    }

    protected function _getCmsFileData(CmsStorageFile $file)
    {
        $fileData = [
            'name' => $file->fileName,
            'value' => $file->id,
            'state' => 'success',
            'size' => $file->size,
            'type' => $file->mime_type,
            'src' => $file->src,
        ];

        // дополнительные поля для редактирования
        if($this->additionalFields){
            $fileData['additionalFields'] = [];
            $this->clientOptions['additionalFields'] = [];
            foreach ($this->additionalFields as $field){
                if($file->canGetProperty($field)){
                    $fileData['additionalFields'][$field] = [
                        'label'=> $file->attributeLabels()[$field],
                        'value'=> $file->{$field} ? $file->{$field} : '',
                    ];
                }

            }
        }


        if ($file->isImage()) {
            $fileData['image'] = [
                'height' => $file->image_height,
                'width' => $file->image_width,
            ];

            $fileData['preview'] = Html::img($file->src);
        }

        return $fileData;
    }

}