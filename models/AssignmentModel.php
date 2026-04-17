<?php

namespace App\Models;

use App\Config\Database;

class AssignmentModel
{
    private $conn;

    public function __construct(private Database $db)
    {
        $this->conn = $db->getConnection();
    }

    public function insert($groupId, $ruleId, $parentId, $tier)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO group_rule_assignments (group_id, rule_id, parent_id, tier)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("iiii", $groupId, $ruleId, $parentId, $tier);

        return $stmt->execute();
    }

    public function getByGroup($groupId)
    {
        $stmt = $this->conn->prepare("
            SELECT gra.*, r.rule_name, r.rule_type
            FROM group_rule_assignments gra
            JOIN rules r ON gra.rule_id = r.rule_id
            WHERE gra.group_id = ?
        ");

        $stmt->bind_param("i", $groupId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT gra.*, r.rule_type
            FROM group_rule_assignments gra
            JOIN rules r ON gra.rule_id = r.rule_id
            WHERE gra.id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}