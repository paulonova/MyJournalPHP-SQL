<?php
session_start();

if ($_SESSION["loggedIn"]) {
    $statement = $pdo->prepare("SELECT * FROM users");
    $statement->execute();
    echo $statement->fetchAll();
} else {
    echo "Unathorized";
}
