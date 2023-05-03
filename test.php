<?php
include "includes/config.php";
$stmt=$dbh->query("SELECT * FROM users");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    var_dump($row);
}
