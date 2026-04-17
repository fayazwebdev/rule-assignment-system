<!DOCTYPE html>
<html>
<head>
    <title>Rule Assignment System</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f6f8;
        }

        .navbar {
            background-color: #2c3e50;
            padding: 15px;
        }

        .navbar a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        h1, h2 {
            color: #333;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }

        .card ul li {
          cursor: pointer;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #2980b9;
        }

        select, input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="create_group.php">Create Group</a>
    <a href="assign_rule.php">Assign Rule</a>
</div>

<div class="container">