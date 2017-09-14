<?php

class m170913_204546_users_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            "users",
            array(
                "id"         => "INT(11) NOT NULL AUTO_INCREMENT",
                "name"       => "VARCHAR(250) NULL DEFAULT NULL",
                "email"      => "VARCHAR(150) NOT NULL",
                "password"   => "VARCHAR(250) NULL DEFAULT NULL",
                "code"       => "VARCHAR(20) NULL DEFAULT NULL",
                "status"     => "TINYINT(1) NOT NULL  DEFAULT '0'",
                "role"       => "VARCHAR(50) NULL DEFAULT 'user'",
                "updated_at" => "TIMESTAMP NULL",
                "created_at" => "TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP",
                "PRIMARY KEY (id)",
            ),
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
        );
        $this->createIndex('IND_users_email', 'users', 'email', true);
        $this->createIndex('IND_users_status', 'users', 'status');
	}

	public function down()
	{
        $this->dropTable('users');
	}
}