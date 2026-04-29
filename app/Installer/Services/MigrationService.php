<?php

namespace App\Installer\Services;

use App\Core\Database\Database;
use App\Core\Database\Migrator;

final class MigrationService
{
    public function run(Database $db): void
    {
        $migrator = new Migrator(
            $db,
            base_path('database/migrations')
        );

        $migrator->migrate();
    }
}