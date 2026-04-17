<?php

namespace App\Classes;

use App\Models\RuleModel;

class Rule
{

    public function __construct(private RuleModel $ruleModel)
    {
    }

    public function create($ruleName, $ruleType)
    {
        // Validation
        if (empty($ruleName) || empty($ruleType)) {
            return false;
        }

        if (!in_array($ruleType, ['CONDITION', 'DECISION'])) {
            return false;
        }

        return $this->ruleModel->insert($ruleName, $ruleType);
    }

    public function getAll()
    {
        return $this->ruleModel->getAll();
    }

    public function getById($id)
    {
        return $this->ruleModel->getById($id);
    }
}