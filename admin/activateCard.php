<?php require_once('Connections/conn.php'); ?>
<?php
$userID = $_GET['id'];

$updateSQL = "UPDATE registration SET status = 1 WHERE id = $userID";

  $Result1 = mysqli_query($conn, $updateSQL);
  
  $urlUpdated = "allCustomer.php";
  header("Location: " . $urlUpdated);
  
?>