<?php

class ActivityLog {
    private $conn;
    private $table = 'activity_logs';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM $this->table ORDER BY created_at DESC";
        return $this->conn->query($query);
    }

    public function create($user_id, $username, $aktivitas, $ip_address, $user_agent) {
        $query = "INSERT INTO $this->table
                  (user_id, username, aktivitas, ip_address, user_agent)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "issss",
            $user_id,
            $username,
            $aktivitas,
            $ip_address,
            $user_agent
        );

        return $stmt->execute();
    }

    public function getLoginHistory() {
        $query = "SELECT * FROM $this->table
                  WHERE aktivitas LIKE '%Login%'
                     OR aktivitas LIKE '%Logout%'
                  ORDER BY created_at DESC";

        return $this->conn->query($query);
    }
}
?>