<?php
  if(isset($_POST['pageLoc'])){
    $pageLoc = $_POST['pageLoc'];
    setcookie("pageLoc", $pageLoc, time()+300);
  }
?>
