<?php
  include('database.php');
  include('user.php');

  if(isset($_POST['likerUsername'])){
    $user = new User($_POST['likerUsername']);
    if(isset($_POST['likeCheckInUsername'])){
      $user->likeCheckIn($_POST['likeCheckInUsername'], $_POST['likeCheckInPlaceID'], $_POST['likeCheckInDatetime']);
    }
    elseif(isset($_POST['dislikeCheckInUsername'])){
      $user->dislikeCheckIn($_POST['dislikeCheckInUsername'], $_POST['dislikeCheckInPlaceID'], $_POST['dislikeCheckInDatetime']);
    }
  }

  if(isset($_POST['commentLikeUsername'])){
    $user = new User($_POST['commentLikeUsername']);
    $user->likeComment($_POST['commentLikePlaceID'], $_POST['commentLikeCommentID']);
  }
  elseif (isset($_POST['commentDislikeUsername'])) {
    $user = new User($_POST['commentDislikeUsername']);
    $user->dislikeComment($_POST['commentDislikePlaceID'], $_POST['commentDislikeCommentID']);
  }
?>
