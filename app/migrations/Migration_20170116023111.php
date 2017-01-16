<?php

namespace app\migrations;

use mako\database\migrations\Migration;

class Migration_20170116023111 extends Migration
{
	/**
	 * Description.
	 *
	 * @var string
	 */
	protected $description = 'Creates products table';

	/**
	 * Makes changes to the database structure.
	 *
	 * @access public
	 */
	public function up()
	{
		$connection = $this->database->connection();
		$connection->query('CREATE TABLE `products` (
		`product_id` int(11) NOT NULL AUTO_INCREMENT ,
		`product_code` varchar(255) NOT NULL,
		`product_name` varchar(255) NOT NULL,
		`product_quantity` int(11) NOT NULL DEFAULT 0,
		`manufacturer_id` int(11) NOT NULL DEFAULT 1,
		`product_price` double NOT NULL DEFAULT 0,
		`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		 PRIMARY KEY (`product_id`)
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
		$connection->query('DROP TABLE `products`');
	}
}
