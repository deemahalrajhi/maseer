<?php
session_start();
require('inpro/db.php');
if (isset($_REQUEST["gate"])) {
  $timestamp = time();
  if(isset($_SESSION['lastModified'])){
    $_SESSION['lastModifiedBefore'] = $_SESSION['lastModified'];
  }
  $_SESSION['lastModified'] = date('Y-m-d H:i', $timestamp);

  $query = "UPDATE gates_info SET status = :status, last_modified = :timestamp WHERE gate = :gate";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':status', $_REQUEST["status"]);
  $stmt->bindParam(':timestamp', $_SESSION['lastModified']);
  $stmt->bindParam(':gate', $_REQUEST["gate"]);

  $stmt->execute();
}
?>