<?php

namespace App\Core;

use App\Core\Database;
use PDO;

class QueryBuilder
{
    private PDO $connection;
    private string $table;
    private array $columns = ["*"];
    private array $whereConditions = [];
    private array $bindings = [];

    private function __construct(string $table)
    {
        $this->connection = Database::connect();
        $this->table = $table;
    }

    public static function table(string $table): self
    {
        return new self($table);
    }

    public function select(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function where(string $column, $value): self
    {
        $this->whereConditions[] = "$column = ?";
        $this->bindings[] = $value;

        return $this;
    }

    public function get(): array
    {
        $columns = implode(",", $this->columns);

        $sql = "SELECT $columns FROM {$this->table}";

        if (!empty($this->whereConditions)) {

            $where = implode(" AND ", $this->whereConditions);

            $sql .= " WHERE $where";
        }

        $stmt = $this->connection->prepare($sql);

        $stmt->execute($this->bindings);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first(): array
    {
        $results = $this->get();

        return $results[0] ?? [];
    }

    public function insert(array $data): bool
    {
        $columns = implode(",", array_keys($data));

        $placeholders = rtrim(str_repeat("?,", count($data)), ",");

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(array_values($data));
    }

    public function update(array $data): bool
    {
        $setParts = [];
        $bindings = [];

        foreach ($data as $column => $value) {

            $setParts[] = "$column = ?";
            $bindings[] = $value;
        }

        $setSql = implode(", ", $setParts);

        $sql = "UPDATE {$this->table} SET $setSql";

        if (!empty($this->whereConditions)) {

            $where = implode(" AND ", $this->whereConditions);

            $sql .= " WHERE $where";

            $bindings = array_merge($bindings, $this->bindings);
        }

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute($bindings);
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM {$this->table}";

        if (!empty($this->whereConditions)) {

            $where = implode(" AND ", $this->whereConditions);

            $sql .= " WHERE $where";
        }

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute($this->bindings);
    }

    public function raw(string $sql, array $bindings = []): array
    {
        $stmt = $this->connection->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
