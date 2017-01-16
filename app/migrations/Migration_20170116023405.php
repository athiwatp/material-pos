<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116023405 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates customer_history table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
		$connection->query('CREATE TABLE `customer_history` (
		`chistory_id` int(11) NOT NULL AUTO_INCREMENT ,
		`customer_id` int(11) NOT NULL,
		`account_id` int(11) NOT NULL,
		`action` int(11) NOT NULL DEFAULT 0,
		`created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		`updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`chistory_id`)
		) ;');
	}

	/**
	 * Reverts the database changes.
	 *
	 * @access public
	 */
	public function down()
	{
		$connection = $this->database->connection();
		$connection->query('DROP TABLE `customer_history`');
	}
}
