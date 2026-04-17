<?php

require_once __DIR__ . '/../config/autoload.php';

use App\Config\Database;
use App\Models\GroupModel;
use App\Models\AssignmentModel;
use App\Models\RuleModel;
use App\Classes\Assignment;

// Initialize
$db = new Database();

$groupModel = new GroupModel($db);
$assignmentModel = new AssignmentModel($db);
$ruleModel = new RuleModel($db);

$assignment = new Assignment($assignmentModel, $ruleModel);

// Fetch all groups
$groups = $groupModel->getAll();

// Tree function
function renderTree($nodes)
{
    if (empty($nodes)) return;

    echo "<ul>";

    foreach ($nodes as $node) {
        echo "<li>";

        echo "<span class='node'>";

        if (isset($node['children'])) {
            echo "<span class='toggle-icon'>[+]</span> ";
        }

        echo htmlspecialchars($node['rule_name']) . " (" . $node['rule_type'] . ")";

        echo "</span>";

        if (isset($node['children'])) {
            echo "<div class='children'>";
            renderTree($node['children']);
            echo "</div>";
        }

        echo "</li>";
    }

    echo "</ul>";
}

// Header
require_once 'partials/header.php';
?>

<h1>All Groups - Rule Hierarchy</h1>

<?php if (empty($groups)): ?>

    <div class="card">
        <p>No groups found.</p>
        <a href="create_group.php">
            <button>Create Your First Group</button>
        </a>
    </div>

<?php else: ?>

<?php foreach ($groups as $group): ?>

    <div class="card group">

        <h2><?= htmlspecialchars($group['group_name']) ?></h2>

        <?php
            $tree = $assignment->getGroupHierarchy($group['group_id']);

            if (!empty($tree)) {
                renderTree($tree);
            } else {
                echo "<p>No rules assigned</p>";
            }
        ?>

    </div>

<?php endforeach; ?>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    // Hide all children initially
    $('.children').hide();

    // Ensure all nodes start with [+]
    $('.node').each(function() {
        if ($(this).siblings('.children').length) {
            $(this).find('.toggle-icon').text('[+]');
        }
    });
    $('.node').click(function(e) {
        e.stopPropagation();

        let children = $(this).siblings('.children');
        let icon = $(this).find('.toggle-icon');

        children.toggle();

        if (children.is(':visible')) {
            icon.text('[-]');
        } else {
            icon.text('[+]');
        }
    });

});
</script>

<?php
// Footer
require_once 'partials/footer.php';
?>