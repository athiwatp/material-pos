<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116020729 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates customers table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
		$connection->query('CREATE TABLE `customers` (
		`customer_id` int(11) NOT NULL AUTO_INCREMENT,
		`customer_code` char(36) COLLATE utf8_unicode_ci DEFAULT NULL,
		`customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		`customer_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		`customer_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		`customer_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		`customer_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		`customer_credit_limit` int(11) NOT NULL DEFAULT 1,
		`status` int(11) NOT NULL DEFAULT 1,
		`created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		`updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		 PRIMARY KEY (`customer_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

	}

	/**
	 * Reverts the database changes.
	 *
	 * @access public
	 */
	public function down()
	{
		$connection = $this->database->connection();
		$connection->query('DROP TABLE customers');
	}
}
