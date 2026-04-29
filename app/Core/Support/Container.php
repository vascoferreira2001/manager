<?php

namespace App\Core\Support;

use RuntimeException;

final class Container
{
    private array $bindings = [];
    private array $instances = [];

    public function set(string $id, callable $factory): void
    {
        $this->bindings[$id] = $factory;
    }

    public function get(string $id): mixed
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->bindings[$id])) {
            throw new RuntimeException("Service não registado: {$id}");
        }

        $this->instances[$id] = ($this->bindings[$id])();
        return $this->instances[$id];
    }
}