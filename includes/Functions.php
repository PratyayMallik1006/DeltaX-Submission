<?php require_once("Includes/DB.php"); ?>
<?php
function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}


 ?>
