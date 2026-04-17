<?php

require_once __DIR__ . '/../config/autoload.php';

use App\Config\Database;
use App\Models\RuleModel;
use App\Models\GroupModel;
use App\Models\AssignmentModel;
use App\Classes\Assignment;

$db = new Database();

// Models
$ruleModel = new RuleModel($db);
$groupModel = new GroupModel($db);
$assignmentModel = new AssignmentModel($db);

// Class
$assignment = new Assignment($assignmentModel, $ruleModel);

// Fetch data
$rules = $ruleModel->getAll();
$groups = $groupModel->getAll();

// Fetch assignments for parent dropdown
$allAssignments = [];
foreach ($groups as $group) {
    $rows = $assignmentModel->getByGroup($group['group_id']);
    foreach ($rows as $row) {
        $row['group_name'] = $group['group_name'];
        $allAssignments[] = $row;
    }
}

// Handle form
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $groupId = $_POST['group_id'] ?? null;
    $ruleId = $_POST['rule_id'] ?? null;
    $parentId = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
    $tier = $_POST['tier'] ?? null;

    if ($groupId && $ruleId && $tier) {

        try {
            $result = $assignment->assign($groupId, $ruleId, $parentId, $tier);

            if ($result) {
                $message = "<p class='success'>Rule assigned successfully</p>";
            } else {
                $message = "<p class='error'>Invalid hierarchy or duplicate entry</p>";
            }

        } catch (Exception $e) {
            $message = "<p class='error'>Something went wrong</p>";
        }

    } else {
        $message = "<p class='error'>All required fields must be filled</p>";
    }
}

// Header
require_once 'partials/header.php';
?>

<div class="card">

    <h2>Assign Rule</h2>

    <?= $message ?>

    <?php if (empty($groups) || empty($rules)): ?>

        <p class="error">
            Please ensure groups and rules are available before assigning.
        </p>

    <?php else: ?>

    <form method="POST">

        <!-- Group -->
        <label>Group:</label>
        <select name="group_id" required>
            <option value="">Select Group</option>
            <?php foreach ($groups as $group): ?>
                <option value="<?= $group['group_id'] ?>">
                    <?= htmlspecialchars($group['group_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Rule -->
        <label>Rule:</label>
        <select name="rule_id" required>
            <option value="">Select Rule</option>
            <?php foreach ($rules as $rule): ?>
                <option value="<?= $rule['rule_id'] ?>">
                    <?= htmlspecialchars($rule['rule_name']) ?> (<?= $rule['rule_type'] ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Parent -->
        <label>Parent Rule (optional):</label>
        <select name="parent_id">
            <option value="">-- Root Level --</option>

            <?php foreach ($allAssignments as $item): ?>
                <?php if ($item['rule_type'] !== 'DECISION'): ?>
                    <option value="<?= $item['id'] ?>">
                        [<?= htmlspecialchars($item['group_name']) ?>]
                        <?= str_repeat('-- ', $item['tier'] - 1) ?>
                        <?= htmlspecialchars($item['rule_name']) ?> (Tier <?= $item['tier'] ?>)
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <!-- Tier -->
        <label>Tier (1-3):</label>
        <input type="number" name="tier" min="1" max="3" required>

        <button type="submit">Assign Rule</button>

    </form>

    <?php endif; ?>

    <br>
    <a href="index.php">← Back to Home</a>

</div>

<style>
.success {
    color: green;
    background: #eafaf1;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
}

.error {
    color: red;
    background: #fdecea;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
}
</style>

<?php
// Footer
require_once 'partials/footer.php';
?>