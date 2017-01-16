<?php

namespace app\models;

use mako\database\midgard\ORM;

class Log extends ORM
{
    protected $tableName = 'logs';
    protected $primaryKey = 'log_id';
}