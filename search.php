<?php
$stmt = $pdo->prepare("SELECT * FROM `users` WHERE `name` LIKE ? OR `email` LIKE ?");
$stmt->execute([
    "%".$_POST['search']. "%" , "%" .$_POST['search']. "%"
]);
$results = $stmt->fetchAll();