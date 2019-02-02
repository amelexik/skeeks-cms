<?php

use yii\db\Migration;

/**
* Class m190121_123232_cms_content_add_model_class
*/
class m190121_123232_cms_content_add_model_class extends Migration
{
    const  nameTable = '{{cms_content}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        parent::safeUp();
        $this->addColumn(self::nameTable, 'model_class', $this->string(255));
        $this->db->getSchema()->refresh();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::nameTable, 'model_class');

        parent::safeDown();
    }
}
