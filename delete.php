<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
   
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("SELECT * FROM `tasks` WHERE 1") ;

}

    header("Location: index.php?showList=1&toggleView=");
?>


