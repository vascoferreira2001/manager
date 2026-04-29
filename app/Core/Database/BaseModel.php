<?php

namespace App\Core\Database;

use RuntimeException;

abstract class BaseModel
{
    protected static Database $db;

    protected string $table = '';
    protected string $primaryKey = 'id';
    protected array $fillable = [];

    protected array $attributes = [];
    protected bool $exists = false;

    public static function setDatabase(Database $db): void
    {
        static::$db = $db;
    }

    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable, true)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void
    {
        if (in_array($key, $this->fillable, true)) {
            $this->attributes[$key] = $value;
        }
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public static function find(int|string $id): ?static
    {
        $instance = new static();
        $rows = static::$db->query(
            "SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = :id LIMIT 1",
            ['id' => $id]
        );

        if (!$rows) return null;

        $instance->attributes = $rows[0];
        $instance->exists = true;
        return $instance;
    }

    public static function where(string $column, mixed $value): array
    {
        $instance = new static();
        $rows = static::$db->query(
            "SELECT * FROM {$instance->table} WHERE {$column} = :v",
            ['v' => $value]
        );

        return array_map(function ($row) {
            $m = new static();
            $m->attributes = $row;
            $m->exists = true;
            return $m;
        }, $rows);
    }

    public static function all(int $limit = 100): array
    {
        $instance = new static();
        $rows = static::$db->query("SELECT * FROM {$instance->table} ORDER BY {$instance->primaryKey} DESC LIMIT {$limit}");

        return array_map(function ($row) {
            $m = new static();
            $m->attributes = $row;
            $m->exists = true;
            return $m;
        }, $rows);
    }

    public function save(): void
    {
        if ($this->table === '') {
            throw new RuntimeException('Tabela não definida no Model.');
        }

        if ($this->exists) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    private function insert(): void
    {
        $cols = array_keys($this->attributes);
        if (!$cols) throw new RuntimeException('Sem atributos para inserir.');

        $placeholders = array_map(fn($c) => ':' . $c, $cols);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(',', $cols),
            implode(',', $placeholders)
        );

        static::$db->exec($sql, $this->attributes);

        $id = static::$db->lastInsertId();
        $this->attributes[$this->primaryKey] = is_numeric($id) ? (int)$id : $id;
        $this->exists = true;
    }

    private function update(): void
    {
        $id = $this->attributes[$this->primaryKey] ?? null;
        if ($id === null) throw new RuntimeException('Primary key em falta para update.');

        $cols = array_keys($this->attributes);
        $cols = array_filter($cols, fn($c) => $c !== $this->primaryKey);

        $sets = array_map(fn($c) => "{$c} = :{$c}", $cols);

        $params = $this->attributes;
        $params['_pk'] = $id;

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = :_pk",
            $this->table,
            implode(',', $sets),
            $this->primaryKey
        );

        static::$db->exec($sql, $params);
    }

    public function delete(): void
    {
        $id = $this->attributes[$this->primaryKey] ?? null;
        if ($id === null) return;

        static::$db->exec(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id",
            ['id' => $id]
        );

        $this->exists = false;
    }
}

