<?php
$host = 'localhost';
$db= 'tasks2';
$user = 'root';
$password = 'root';
$dsn = 'mysql:host='.$host.';dbname='.$db;
$pdo = new PDO($dsn,$user,$password);