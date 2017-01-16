<?php

namespace app\models;

use mako\database\midgard\ORM;

class Customer extends ORM
{
    protected $tableName = 'customers';
    protected $primaryKey = 'customer_id';
}