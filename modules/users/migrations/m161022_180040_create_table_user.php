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
            'email' => $this->string()->notNull()->unique()->comment('Email'),
            'auth_key' => $this->string(32)->notNull()->unique()->comment('Authorization Key'),
            'password_hash' => $this->string()->notNull()->comment('Hash Password'),
            'password_reset_token' => $this->string()->unique()->comment('Password Token'),
            'email_confirm_token' => $this->string()->unique()->comment('Email Confirm Token'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Status'),
        ], $tableOptions);

        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'user_id' => $this->integer()->notNull()->comment('User'),
            'first_name' => $this->string()->comment('First Name'),
            'last_name' => $this->string()->comment('Last Name'),
            'email_gravatar' => $this->string()->unique()->comment('Email Gravatar'),
            'last_visit' => $this->integer()->comment('Last Visit'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
        ], $tableOptions);

        $this->createIndex('IDX_user_profile_user_id', '{{%user_profile}}', 'user_id');
        $this->addForeignKey('FK-user_profile-user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');
    }
}
