<?php

namespace Core;

class UserRepository{
    private Database $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function existsByEmail(string $email): bool{
        $result = $this->db->query("SELECT id FROM users WHERE email = ?", [$email]);
        return $result && $result->num_rows > 0;
    }

    public function insert(array $data): int {
        $posted = $data['posted'] ?? 'NOW()';
        $this->db->query("INSERT INTO users (email, password, posted) VALUES (?, ?, $posted)", [$data['email'], $data['password']]);
        return $this->db->lastInsertId();
    }

    public function insertLog(int $userId): void{
        $this->db->query("INSERT INTO user_log (action, user_id, log_time) VALUES ('register', ?, 'NOW()')", [$userId]);
    }
}