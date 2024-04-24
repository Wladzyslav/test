<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список дел</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Список дел</h1>
    <?php
    require_once("connect.php");
    ?>
    <table>
        <?php
        $sort = "DESC";
        if (!empty($_POST['reload'])) {
            Header('Location: /');
        }
        $query = "";
        if (!empty($_POST["date-from"]) && !empty($_POST["date-to"])) {
            $query .= " AND UNIX_TIMESTAMP(t.date_create) BETWEEN " . strtotime($_POST["date-from"]) . " AND " . strtotime($_POST["date-to"]);
        }
        if (!empty($_POST["date-from"]) && empty($_POST["date-to"])) {
            $query .= " AND UNIX_TIMESTAMP(t.date_create) >= " . strtotime($_POST["date-from"]);
        }
        if (!empty($_POST["date-to"]) && empty($_POST["date-from"])) {
            $query .= " AND UNIX_TIMESTAMP(t.date_create) <= " . strtotime($_POST["date-to"]);
        }
        if (!empty($_POST["status_id"])) {
            $query .= " AND t.status_id = " . $_POST["status_id"];
        }
        if (!empty($_POST["importance_id"])) {
            $query .= " AND t.importance_id = " . $_POST["importance_id"];
        }
        $sql = "SELECT
    t.task_id,
    t.description, 
    i.importance_degree, 
    s.status_name, 
    t.date_create, 
    t.status_changed 
    FROM task t 
    JOIN status s 
    on t.status_id=s.status_id
    JOIN importance i
    on t.importance_id=i.importance_id 
    $query 
    ORDER BY t.date_create
    $sort";

        $query = $pdo->prepare($sql);
        $query->execute();
        $tasks = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($tasks) > 0) {
            ?>
            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Описание</th>
                <th>Дата создания</th>
                <th>Степень важности</th>
                <th>Статус</th>
                <th>Дата последнего изменения статуса</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($tasks as $index => $task) {
                echo "<tr>
      <td>" . ++$index . "</td>
      <td>$task->description</td>
      <td>" . date("d.m.Y H:i:s", strtotime($task->date_create)) . "</td>
      <td>$task->importance_degree </td>
      <td>$task->status_name </td>
      <td>" . (!empty($task->status_changed) ? date("d.m.Y H:i:s", strtotime($task->status_changed)) : '-') . "</td>
      <td><a href='edit_task.php?task_id=$task->task_id'>Редактировать</button></td>
      <td><a href='delete_task.php?task_id=$task->task_id'>Удалить</button></td>
      </tr>";
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>№ п/п</th>
                <th>Описание</th>
                <th>Дата создания</th>
                <th>Степень важности</th>
                <th>Статус</th>
                <th>Дата последнего изменения статуса</th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
            <?php
        } else {
            echo "<tr><td colspan='8' class='border-0'>Нет данных. Измените, пожалуйста, критерии поиска</td></tr>";
        }
        ?>
    </table>
    <p style="text-align: right;"><a href="add_task.php">Добавить дело</a></p>
    <?php
    require_once("dictionaries.php");
    ?>

    <p id="message"></p>

    <form action="" method="post">
        <div class="filter-wrapper">
            <div>
                <div>
                    <label for="date-from">Дата создания С:</label><input type="date" name="date-from" id="date-from"
                                                                          value="<?php if (isset($_POST['date-from'])) echo $_POST['date-from'] ?>">
                </div>
                <div class="mt-10">
                    <label for="date-to">Дата создания ПО:</label><input type="date" name="date-to" id="date-to"
                                                                         value="<?php if (isset($_POST['date-to'])) echo $_POST['date-to'] ?>">
                </div>
            </div>
            <div class="d-flex">
                <label>Статус:
                    <select name="status_id" id="status_id">
                        <option value="">-</option>
                        <?php foreach ($statuses as $status) { ?>
                            <option value='<?= $status->status_id ?>' <?= ($status->status_id == $_POST['status_id'] ? "selected" : "") ?> ><?= $status->status_name ?></option>
                        <?php } ?>
                    </select>
                </label>
            </div>
            <div>
                <label>Степень важности:
                    <select name="importance_id" id="importance_id">
                        <option value="">-</option>
                        <?php foreach ($importances as $importance) { ?>
                            <option value='<?= $importance->importance_id ?>' <?= ($importance->importance_id == $_POST['importance_id'] ? "selected" : "") ?> ><?= $importance->importance_degree ?></option>
                        <?php } ?>
                    </select>
                </label>
            </div>
            <div>
                <button type="submit" class="mt-20" onclick="return checkFields();">Отфильтровать</button>
                <input type="submit" name="reload" value="Очистить фильтр" class="mt-20">
            </div>
    </form>
    </div>
</main>
<script src="script.js"></script>
</body>
</html>