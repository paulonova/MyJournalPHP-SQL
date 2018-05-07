<?php 

// header('Location: /journal.php');
require_once 'session_start.php';
require_once "../classes/entry.php";
require_once 'database.php';

$statement = $pdo->prepare("DELETE FROM entries WHERE entryID= :entryID");
$statement->execute([
    "entryID" => $_GET['del']
]);

$_SESSION['msg'] = "Successfully deleted..";
header('Location: /journal.php');

?>