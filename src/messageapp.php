<?php
include('database.php');
include('user.php');
if(isset($_POST['user'])){
  $user = new User($_POST['user']);
  $chatUser = new User($_POST['chat']);
  $user->printMessagesWith($chatUser);
}

if(isset($_POST['sender'])){
  $sender = new User($_POST['sender']);
  $receiver = new User($_POST['receiver']);
  $message = $_POST['message'];
  $sender->sendMessageTo($receiver, $message);
}
?>
