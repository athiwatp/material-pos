<?php

namespace app\models;

use mako\database\midgard\ORM;

class User extends ORM
{
    protected $tableName = 'users';
}