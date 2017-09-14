<?php

class m170914_060535_users_bonus extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            "users_bonus",
            [
                "id"         => "INT(11) NOT NULL AUTO_INCREMENT",
                "user_id"    => "INT(11) NOT NULL",
                "bonus"      => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
                "updated_at" => "TIMESTAMP NULL",
                "created_at" => "TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP",
                "PRIMARY KEY (id)",
            ],
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"
        );
        $this->createIndex('IND_users_bonus_user_id', 'users_bonus', 'user_id');
        $this->addForeignKey('FK_users_bonus_user_id_to_users_id', 'users_bonus', 'user_id', 'users', 'id', 'CASCADE');
	}

	public function down()
	{
	    $this->dropForeignKey('FK_users_bonus_user_id_to_users_id', 'users_bonus');
        $this->dropTable('users_bonus');
	}
}