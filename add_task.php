<?php
require_once("connect.php");
if (isset($_POST["description"]) && isset($_POST["importance_id"]) && isset($_POST["status_id"])) {
    $sql = 'INSERT INTO task (description,importance_id,status_id) VALUES(:description,:importance_id,:status_id)';
    $stmt = $pdo->prepare($sql);
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
    <title>Создать дело</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Создать дело</h1>
    <?php
    require_once("connect.php");
    ?>
    <form action="" method="post">
        <table>
            <tbody>
            <?php
            require_once("dictionaries.php");
            ?>
            <tr>
                <td>Описание</td>
                <td>
                    <input title="Разрешено использовать только пробелы и буквы русского и латинского алфавита" type='text' name='description' required pattern="^[а-яА-ЯёЁa-zA-Z0-9\s]+$"></td>
            </tr>
            <tr>
                <td>Степень важности</td>
                <td>
                    <select name='importance_id' required>
                        <option value="">-</option>
                        <?php foreach ($importances as $importance) { ?>
                            <option value='<?= $importance->importance_id ?>'><?= $importance->importance_degree ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Статус</td>
                <td>
                    <select name='status_id' required>
                        <option value="">-</option>
                        <?php foreach ($statuses as $status) { ?>
                            <option value='<?= $status->status_id ?>'><?= $status->status_name ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><a href="/">Вернуться к списку дел</a></td>
                <td><input type='submit' name='post' value='Сохранить'></td>
            </tr>
            </tbody>
        </table>
    </form>
</main>
</body>
</html>