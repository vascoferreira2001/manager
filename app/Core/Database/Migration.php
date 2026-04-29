<?php

namespace App\Core\Database;

abstract class Migration
{
    abstract public function up(Database $db): void;
    abstract public function down(Database $db): void;
}