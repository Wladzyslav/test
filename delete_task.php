
<?php
require_once("connect.php");

if (!empty($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
}

else {
    echo "<h1>Некорректные данные</h1><p><a href=\"/\">Вернуться к списку дел</a></p>";
    die();
}

$sql =  'DELETE FROM task WHERE task_id = ?';
$query = $pdo->prepare($sql);
$query->execute([$task_id]);

header("Location: /");



