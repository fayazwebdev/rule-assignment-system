<?php

namespace App\Classes;

use App\Models\AssignmentModel;

class Assignment
{
    public function __construct(
        private AssignmentModel $assignmentModel
    ) {}

    public function assign($groupId, $ruleId, $parentId, $tier)
    {
        // 1. Validate tier
        if ($tier < 1 || $tier > 3) {
            return false;
        }

        // 2. If parent exists → validate parent rule type
        if (!empty($parentId)) {
            $parent = $this->assignmentModel->getById($parentId);

            if (!$parent) {
                return false;
            }

            // Decision rule cannot have children
            if ($parent['rule_type'] === 'DECISION') {
                return false;
            }

            // Tier validation (parent tier + 1)
            if ($parent['tier'] + 1 != $tier) {
                return false;
            }
        } else {
            // Root level must be tier 1
            if ($tier != 1) {
                return false;
            }
        }
        try {
          return $this->assignmentModel->insert($groupId, $ruleId, $parentId, $tier);
        } catch (\mysqli_sql_exception $e) {
          return false;
        }
    }

    public function getGroupHierarchy($groupId)
    {
        $rows = $this->assignmentModel->getByGroup($groupId);

        return $this->buildTree($rows);
    }

    private function buildTree($elements, $parentId = null)
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);

                if ($children) {
                    $element['children'] = $children;
                }

                $branch[] = $element;
            }
        }

        return $branch;
    }
}