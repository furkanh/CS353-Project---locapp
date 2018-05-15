<?php
  include('database.php');
  include('user.php');

  $user = new User();
  $user->authenticate();

  if(isset($_POST['acceptrequestmodal'])){
    $username = $_POST['addedusername'];
    $acceptedUser = new User($username);
    $user->acceptRequest($acceptedUser);
  }
  elseif (isset($_POST['rejectrequestmodal'])) {
    $username = $_POST['addedusername'];
    $rejectedUser = new User($username);
    $user->rejectRequest($rejectedUser);
  }


 ?>
