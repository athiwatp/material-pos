<?php

namespace app\models;

use mako\database\midgard\ORM;

class Sale extends ORM
{
    protected $tableName = 'sales';
    protected $primaryKey = 'sales_id';
}