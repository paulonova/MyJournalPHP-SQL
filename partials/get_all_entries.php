<?php 
require_once 'database.php';
require_once 'session_start.php';

$_SESSION["journal_title"] = $_POST['journal_title'];



echo "EntryID: " . $_SESSION['entryID'] . "<br/>";
echo "Title: " . $_POST['journal_title'] . "<br/>";
echo "TextArea: " . $_POST['journal_area'] . "<br/>";
echo "Date: " . $_POST['journal_date'] . "<br/>";
echo "UserID: " . $_SESSION['user_id'];


/*
If $_POST is save or edit, this functions make the work!
*/
if(isset($_POST['update'])){
    $entryID = $_SESSION['entryID'];
    $title = $_POST['journal_title'];
    $content = $_POST['journal_area'];
    $date = explode(" ",$_POST['journal_date']);
    $userID = $_SESSION['user_id'];

    $statement = $pdo->prepare("UPDATE entries SET title='$title', content='$content', 
                                       createdAt='$date[0]', userID='$userID' 
                                WHERE entryID= :entryID ");
    $statement->execute([
        "entryID" => $entryID
    ]);
    header('Location: /journal.php'); 
    $_SESSION['msg'] = "Successfully updated..";
}


if(isset($_POST['save'])){
    $statement = $pdo->prepare("INSERT INTO entries (entryID, title, content, createdAt, userID) 
    VALUES (NULL, :title, :content, :created, :userId);");

    $statement->execute([
        ":title" =>     $_POST['journal_title'],
        ":content" =>   $_POST['journal_area'],
        ":created" =>   $_POST['journal_date'],
        ":userId" =>    $_SESSION['user_id']
    ]);
    header('Location: /journal.php'); 
    $_SESSION['msg'] = "Successfully saved..";
}

    

?>