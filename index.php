<?php
session_start();
include 'logic.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe Game</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Tic Tac Toe</h1>
    <?php include 'game_ui.php'; ?>
</body>

</html>