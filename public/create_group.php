<?php

require_once __DIR__ . '/../config/autoload.php';

use App\Config\Database;
use App\Models\GroupModel;
use App\Classes\Group;

// Init
$db = new Database();

$groupModel = new GroupModel($db);
$group = new Group($groupModel);

$message = "";

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $groupName = trim($_POST['group_name']);

    if (!empty($groupName)) {

        if ($group->create($groupName)) {
            $message = "<p class='success'>Group created successfully</p>";
        } else {
            $message = "<p class='error'>Failed to create group</p>";
        }

    } else {
        $message = "<p class='error'>Group name cannot be empty</p>";
    }
}

// Header
require_once 'partials/header.php';
?>

<div class="card">

    <h2>Create New Group</h2>

    <?= $message ?>

    <form method="POST">

        <label>Group Name:</label>
        <input type="text" name="group_name" placeholder="Enter group name" required>

        <button type="submit">Create Group</button>

    </form>

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