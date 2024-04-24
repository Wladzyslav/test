<?php
$importance_dictionary = "SELECT * from importance";
$query = $pdo->prepare($importance_dictionary);
$query->execute();
$importances = $query->fetchAll(PDO::FETCH_OBJ);

$status_dictionary = "SELECT * from status";
$query = $pdo->prepare($status_dictionary);
$query->execute();
$statuses = $query->fetchAll(PDO::FETCH_OBJ);