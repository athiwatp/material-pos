<?php

namespace app\models;

use mako\database\midgard\ORM;

class SaleSummary extends ORM
{
    protected $tableName = 'sales_summary';
    protected $primaryKey = 'sale_id';
}