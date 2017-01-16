<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116023728 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates payment_history table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
        $connection->query('CREATE TABLE `payment_history` (
		`payment_id` int(11) NOT NULL AUTO_INCREMENT ,
		`payment_amount` double NOT NULL,
		`or_number` varchar(255) NOT NULL,
		`account_id` int(11) NOT NULL,
		`notes` text NOT NULL,
		`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		 PRIMARY KEY (`payment_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;');
	}

	/**
	 * Reverts the database changes.
	 *
	 * @access public
	 */
	public function down()
	{
		$connection = $this->database->connection();
        $connection->query('DROP TABLE `payment_history`');
	}
}
