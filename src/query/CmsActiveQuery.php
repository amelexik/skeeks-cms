<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 09.03.2015
 */

namespace skeeks\cms\query;

use skeeks\cms\components\Cms;
/** BEGIN OF AMELEX CHANGES */
use skeeks\cms\tag\behaviors\CmsTagQueryBehavior;
/** END OF AMELEX CHANGES */

use yii\db\ActiveQuery;

/**
 * Class CmsActiveQuery
 * @package skeeks\cms\query
 */
class CmsActiveQuery extends ActiveQuery
{
    public $is_active = true;

    /** BEGIN OF AMELEX CHANGES */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            CmsTagQueryBehavior::className()
        ]);
    }
    /** END OF AMELEX CHANGES */


    /**
     * @param bool $state
     * @return $this
     */
    public function active($state = true)
    {
        if ($this->is_active === true) {
            return $this->andWhere(['is_active' => $state]);
        }

        return $this->andWhere(['active' => ($state == true ? Cms::BOOL_Y : Cms::BOOL_N)]);
    }

    public function def($state = true)
    {
        return $this->andWhere(['def' => ($state == true ? Cms::BOOL_Y : Cms::BOOL_N)]);
    }

    /** BEGIN OF AMELEX CHANGES */

    /**
     * @return $this
     */
    public function published()
    {
        if ($this->is_active === true) {
            $this->andWhere(['is_active' => Cms::BOOL_Y]);
        } else {
            $this->andWhere(['active' => Cms::BOOL_Y]);
        }

        $this->andWhere(
            ["<=", 'published_at', \Yii::$app->formatter->asTimestamp(time())]
        );

        $this->andWhere(
            [
                'or',
                [">=", 'published_to', \Yii::$app->formatter->asTimestamp(time())],
                ['published_to' => null],
            ]
        );

        return $this;
    }

    /**
     * @param int $sort
     * @return $this
     */
    public function orderPublishedAt($sort = SORT_DESC)
    {
        $this->orderBy(['published_at' => $sort]);
        return $this;
    }
    /** END OF AMELEX CHANGES */

}
