<?php

namespace App\Classes;

use App\Models\GroupModel;

class Group
{

    public function __construct(private GroupModel $groupModel)
    {
    }

    public function create($groupName)
    {
        if (empty($groupName)) {
            return false;
        }

        return $this->groupModel->insert($groupName);
    }

    public function getAll()
    {
        return $this->groupModel->getAll();
    }

    public function getById($id)
    {
        return $this->groupModel->getById($id);
    }
}