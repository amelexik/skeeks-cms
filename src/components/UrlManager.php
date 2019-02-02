<?php
/**
 * Created by PhpStorm.
 * User: amelexik
 * Date: 20.11.18
 */

namespace skeeks\cms\components;

use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsSite;
use skeeks\cms\models\CmsTree;
use Yii;

class UrlManager extends \yii\web\UrlManager
{

    public function getIsBackend()
    {
        return strpos(Yii::$app->request->pathInfo, '~sx') !== false;
    }

    public function createUrl($params)
    {


        $url = parent::createUrl($params);
        /**
         * для аминки
         */
        if ($this->getIsBackend()) {
            if (isset($params['model'])) {
                /* @var  CmsContentElement $model */
                $model = $params['model'];
                if ($model instanceof CmsContentElement) {
                    /* @var  CmsTree $tree */
                    if (!$tree = $model->getCmsTree()->one())
                        return $url;
                    /* @var  CmsSite $site */
                    if (!$site = $tree->site)
                        return $url;
                    $siteId = $site->primaryKey;
                    if (!isset(LanguageDetect::getSitesLanguage()[$siteId]))
                        return $url;

                    $sLangCode = LanguageDetect::getSitesLanguage()[$siteId];
                    $sLangPrefix = LanguageDetect::getPrefix($sLangCode);
                    $url = empty($sLangPrefix) ? $url : ('/' . $sLangPrefix . $url);
                    return $url;
                }

                /* @var  CmsContentElement $model */
                if ($model instanceof CmsTree) {
                    if (!$site = $model->site)
                        return $url;
                    $siteId = $site->primaryKey;
                    if (!isset(LanguageDetect::getSitesLanguage()[$siteId]))
                        return $url;

                    $sLangCode = LanguageDetect::getSitesLanguage()[$siteId];
                    $sLangPrefix = LanguageDetect::getPrefix($sLangCode);
                    $url = empty($sLangPrefix) ? $url : ('/' . $sLangPrefix . $url);
                    return $url;
                }
            }
            return $url;
        } else {
            $langPrefix = LanguageDetect::getPrefix(Yii::$app->language);
            $url = empty($langPrefix) ? $url : ('/' . $langPrefix . $url);
        }

        return $url;
    }
}