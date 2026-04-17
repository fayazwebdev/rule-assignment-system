<?php

namespace App\Models;

use App\Config\Database;

class GroupModel
{

    public function __construct(private Database $db, private $conn = null)
    {
        $this->conn = $db->getConnection();
    }

    public function insert($groupName)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO groups (group_name)
            VALUES (?)
        ");

        $stmt->bind_param("s", $groupName);

        return $stmt->execute();
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM groups");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM groups WHERE group_id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}