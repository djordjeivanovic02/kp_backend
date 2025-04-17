<?php

namespace Core;

use Exception;
use mysqli;

class Database {
    private mysqli $connection;

    /**
     * @throws Exception
     */
    public function __construct(string $host, string $user, string $password, string $database) {
        $this->connection = new mysqli($host, $user, $password, $database);

        if($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query(string $query, array $params = []): bool|\mysqli_result {
        if(!empty($params)){
            $stmt = $this->connection->prepare($query);
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->connection->query($query);
    }

    public function lastInsertId(): int{
        return $this->connection->insert_id;
    }
}
