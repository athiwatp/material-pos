<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116024628 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates sales_summary table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
        $connection->query('CREATE TABLE `sales_summary` (
		`sale_id` int(11) NOT NULL AUTO_INCREMENT ,
		`product_id` int(11) NOT NULL,
		`product_name` varchar(255) NOT NULL,
		`sale_quantity` int(11) NOT NULL,
		`or_number` varchar(255) NOT NULL DEFAULT 0,
		`total_price` double NOT NULL,
		`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`sale_id`)
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
        $connection->query('DROP TABLE `sales_summary`');
	}
}
