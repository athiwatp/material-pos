<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116024030 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates product_history table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
        $connection->query('CREATE TABLE `product_history` (
		`phistory_id` int(11) NOT NULL AUTO_INCREMENT ,
		`quantity` int(11) NOT NULL,
		`product_id` int(11) NOT NULL,
		`or_number` varchar(255) NOT NULL,
		`account_id` int(11) NOT NULL,
		`type` int(11) NOT NULL DEFAULT 0,
		`created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		`updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`phistory_id`)
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
        $connection->query('DROP TABLE `product_history`');
	}
}
