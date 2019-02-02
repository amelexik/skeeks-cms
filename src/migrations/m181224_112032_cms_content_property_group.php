<?php

use yii\db\Migration;

/**
* Class m181224_112032_cms_content_property_group
*/
class m181224_112032_cms_content_property_group extends console\components\Migration
{
    const  nameTable = '{{cms_content_property}}';
    
    /**
    * {@inheritdoc}
    */
    public function safeUp()
    {
        parent::safeUp();
        
        $this->addColumn(self::nameTable, 'group', 'integer');
        $this->db->getSchema()->refresh();
    }

    /**
    * {@inheritdoc}
    */
    public function safeDown()
    {
        $this->dropColumn(self::nameTable, 'group');

        parent::safeDown();
    }
}
