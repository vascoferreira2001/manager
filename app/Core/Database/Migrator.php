<?php

namespace App\Core\Database;

final class Migrator
{
    public function __construct(
        private Database $db,
        private string $migrationsPath
    ) {}

    public function migrate(): void
    {
        $this->ensureMigrationsTable();

        $applied = $this->getAppliedMigrations(); // [filename => 1]
        $files = glob($this->migrationsPath . DIRECTORY_SEPARATOR . '*.php') ?: [];

        sort($files);

        foreach ($files as $file) {
            $name = basename($file);
            if (isset($applied[$name])) {
                continue;
            }

            $migration = require $file;
            if (!$migration instanceof Migration) {
                throw new \RuntimeException("Migration inválida: {$name} (deve retornar new class extends Migration)");
            }

            $migration->up($this->db);
            $this->markApplied($name);

            echo "✅ Applied: {$name}\n";
        }

        echo "🎉 Migrations concluídas.\n";
    }

    private function ensureMigrationsTable(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS schema_migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL UNIQUE,
                applied_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function getAppliedMigrations(): array
    {
        $rows = $this->db->query("SELECT migration FROM schema_migrations");
        $map = [];
        foreach ($rows as $r) {
            $map[$r['migration']] = 1;
        }
        return $map;
    }

    private function markApplied(string $migration): void
    {
        $this->db->exec(
            "INSERT INTO schema_migrations (migration) VALUES (:m)",
            ['m' => $migration]
        );
    }
}