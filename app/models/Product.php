<?php

namespace app\models;

use mako\database\midgard\ORM;

class Product extends ORM
{
    protected $tableName = 'products';
    protected $primaryKey = 'product_id';
}