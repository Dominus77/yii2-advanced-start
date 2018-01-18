<?php

namespace modules\users\migrations;

use yii\db\Migration;

/**
 * Class m161022_180040_create_table_user
 * @package modules\users\migrations
 */
class m161022_180040_create_table_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'username' => $this->string()->notNull()->unique()->comment('Username'),
            'auth_key' => $this->string(32)->notNull()->comment('Authorization Key'),
            'password_hash' => $this->string()->notNull()->comment('Hash Password'),
            'password_reset_token' => $this->string()->unique()->comment('Password Token'),
            'email_confirm_token' => $this->string()->comment('Email Confirm Token'),
            'email' => $this->string()->notNull()->unique()->comment('Email'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Status'),
            'last_visit' => $this->integer()->comment('Last Visit'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
            'first_name' => $this->string(45)->comment('First Name'),
            'last_name' => $this->string(45)->comment('Last Name'),
            'registration_type' => $this->integer()->defaultValue(0)->comment('Type Registration'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
