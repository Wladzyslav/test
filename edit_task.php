<?php
require_once("connect.php");

if (!empty($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
} else {
    echo "<h1>Некорректные данные</h1><p><a href=\"/\">Вернуться к списку дел</a></p>";
    die();
}

if (isset($_POST["task_id"]) && isset($_POST["description"]) && isset($_POST["importance_id"]) && isset($_POST["status_id"])) {
    $sql = "UPDATE task SET description = :description, importance_id = :importance_id , status_id = :status_id WHERE task_id = :task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":task_id", $_POST["task_id"]);
    $stmt->bindValue(":description", htmlspecialchars(strip_tags($_POST["description"])));
    $stmt->bindValue(":importance_id", $_POST["importance_id"]);
    $stmt->bindValue(":status_id", $_POST["status_id"]);
    $stmt->execute();
    header("Location: /");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать дело</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Редактировать дело</h1>
    <?php
    require_once("connect.php");
    ?>
    <form action="" method="post">
        <input type="hidden" name="task_id" value="<?= $_GET['task_id'] ?>">
        <table>
            <tbody>
            <?php

            $tasks_list = "SELECT t.*, i.*, s.* FROM task t JOIN status s on t.status_id=s.status_id JOIN importance i on t.importance_id=i.importance_id WHERE t.task_id='$task_id'";
            $query = $pdo->prepare($tasks_list);
            $query->execute();
            $tasks = $query->fetchAll(PDO::FETCH_OBJ);

            require_once("dictionaries.php");

            foreach ($tasks as $task) {
                ?>
                <tr>
                    <td>Описание</td>
                    <td>
                        <input title="Разрешено использовать только пробелы и буквы русского и латинского алфавита" type='text' name='description' value='<?= $task->description ?>' required pattern="^[а-яА-ЯёЁa-zA-Z0-9\s]+$">
                    </td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td><?= date("d.m.Y H:i:s", strtotime($task->date_create)) ?></td>
                </tr>
                <tr>
                    <td>Степень важности</td>
                    <td>
                        <select name='importance_id'>
                            <?php foreach ($importances as $importance) { ?>
                                <option value='<?= $importance->importance_id ?>' <?= ($importance->importance_id == $task->importance_id ? "selected" : "") ?> ><?= $importance->importance_degree ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Статус</td>
                    <td>
                        <select name='status_id'>
                            <?php foreach ($statuses as $status) { ?>
                                <option value='<?= $status->status_id ?>' <?= ($status->status_id == $task->status_id ? "selected" : "") ?> ><?= $status->status_name ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Дата последнего изменения статуса</td>
                    <td><?= (!empty($task->status_changed) ? date("d.m.Y H:i:s", strtotime($task->status_changed)) : '-') ?></td>
                </tr>
                <tr>
                    <td><a href='delete_task.php?task_id=<?= $task->task_id ?>'>Удалить</a></td>
                    <td><input type='submit' name='post' value='Сохранить'></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </form>
    <p><a href="/">Вернуться к списку дел</a></p>
</main>
</body>
</html>