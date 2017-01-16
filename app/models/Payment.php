<?php

namespace app\models;

use mako\database\midgard\ORM;

class Payment extends ORM
{
    protected $tableName = 'payment_history';
    protected $primaryKey = 'payment_id';
}