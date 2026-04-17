<?php

namespace App\Models;

use App\Config\Database;

class RuleModel
{
    private $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getConnection();
    }

    public function insert($ruleName, $ruleType)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO rules (rule_name, rule_type)
            VALUES (?, ?)
        ");

        $stmt->bind_param("ss", $ruleName, $ruleType);

        return $stmt->execute();
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM rules");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM rules WHERE rule_id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}