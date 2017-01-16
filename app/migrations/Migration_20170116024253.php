<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116024253 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates sales table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
        $connection->query('CREATE TABLE `sales` (
		`sales_id` int(11) NOT NULL AUTO_INCREMENT ,
		`customer_id` int(11) NOT NULL,
		`sales_total` double NOT NULL,
		`transaction_type` int(11) NOT NULL,
		`or_number` varchar(255) NOT NULL DEFAULT 0,
		`account_id` int(11) NOT NULL,
		`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		 PRIMARY KEY (`sales_id`)
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
        $connection->query('DROP TABLE `sales`');
	}
}
