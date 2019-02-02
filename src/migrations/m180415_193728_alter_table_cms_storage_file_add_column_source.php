<?php

use yii\db\Migration;

/**
 * Class m180415_193728_alter_table_cms_storage_file_add_column_source
 */
class m180415_193728_alter_table_cms_storage_file_add_column_source extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn("{{%cms_storage_file}}", "source", $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn("{{%cms_storage_file}}", "source");
    }
}
