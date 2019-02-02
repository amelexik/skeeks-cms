<?php
/**
 * m150121_193200_create_table__cms_user_email
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 21.01.2015
 * @since 1.0.0
 */
use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m150121_193200_create_table__cms_user_email
 */
class m150121_193200_create_table__cms_user_email extends Migration
{
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%cms_user_email}}", true);
        if ($tableExist)
        {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%cms_user_email}}", [
            'id'                    => Schema::TYPE_PK,
            'user_id'               => Schema::TYPE_INTEGER . ' NOT NULL',
            'value'                 => Schema::TYPE_STRING. '(255) NOT NULL',
            'approved'              => Schema::TYPE_SMALLINT,
            'approved_key'          => Schema::TYPE_STRING. '(255)',
            'created_at'            => Schema::TYPE_INTEGER . ' NULL',
            'updated_at'            => Schema::TYPE_INTEGER . ' NULL',
        ], $tableOptions);

        $this->execute("ALTER TABLE {{%cms_user_email}} ADD INDEX(approved_key);");
        $this->execute("ALTER TABLE {{%cms_user_email}} ADD INDEX(approved);");
        $this->execute("ALTER TABLE {{%cms_user_email}} ADD INDEX(user_id);");
        $this->execute("ALTER TABLE {{%cms_user_email}} ADD INDEX(created_at);");
        $this->execute("ALTER TABLE {{%cms_user_email}} ADD INDEX(updated_at);");
        $this->execute("ALTER TABLE {{%cms_user_email}} ADD UNIQUE(value);");

        $this->addForeignKey(
            'cms_user_email_user_id', "{{%cms_user_email}}",
            'user_id', '{{%cms_user}}', 'id', 'CASCADE', 'CASCADE'
        );

    }

    public function down()
    {
        $this->dropForeignKey("cms_user_email_user_id", "{{%cms_user_email}}");
        $this->dropTable("{{%cms_user_email}}");
    }
}
