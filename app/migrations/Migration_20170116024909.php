<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116024909 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates users table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
        $connection->query('CREATE TABLE `users` (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`created_at` datetime NOT NULL,
		`updated_at` datetime NOT NULL,
		`ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`action_token` char(64) COLLATE utf8_unicode_ci,
		`access_token` char(64) COLLATE utf8_unicode_ci,
		`activated` tinyint(1) NOT NULL DEFAULT 0,
		`banned` tinyint(1) NOT NULL DEFAULT 0,
		`failed_attempts` int(11) NOT NULL DEFAULT 0,
		`last_fail_at` datetime DEFAULT NULL,
		`locked_until` datetime DEFAULT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY `username` (`username`),
		UNIQUE KEY `email` (`email`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	');
	}

	/**
	 * Reverts the database changes.
	 *
	 * @access public
	 */
	public function down()
	{
		$connection = $this->database->connection();
        $connection->query('DROP TABLE `users`');
	}
}
