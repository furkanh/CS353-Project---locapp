<!DOCTYPE html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    <title></title>
  </head>
  <body>
    <?php
      include('authentication.php');
    ?>

    <!-- navbar for title -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#444444;">
  <a class="navbar-brand" href="index.php">
    <img src="./img/logo.png" width="111" height="40" class="d-inline-block align-top" alt="">
  </a>
  <a class="navbar-brand" href="profile.php?uname=<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php
        if($user->isPlaceOwner()){
          echo "<li class='nav-item'>
            <a class='nav-link' href='myplaces.php'>My Places</a>
            </li>";
        }
      ?>
      <li class="nav-item">
        <a class="nav-link" href="checkin.php">Check-In</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="settings.php">Settings</a>
      </li>
    </ul>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mr-sm-4" data-toggle="modal" data-target="#notificationModal">
      Notifications <span class='badge badge-pill badge-light'> <?php echo $user->getNumOfNotifications(); ?> </span>
    </button>
        <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name=search>
          <button class="btn btn-outline-success my-2 mr-sm-2" type="submit">Search</button>
        </form>

        <form class="form-inline my-2 my-lg-0" method="post">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name=logout>Log Out</button>
        </form>

  </div>
</nav>

<!-- Friend Request Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Notifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <?php
            $user->printNotifications();
          ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- content here -->

<?php
  $visitedPlace = null;
  if(isset($_GET["place"])){
      $visitedPlace = new Place($_GET["place"]);
  }
  else{
    header("Location:index.php");
    exit();
  }

  if(isset($_POST['rate'])){
    $user->ratePlace($visitedPlace, $_POST['ambiance'], $_POST['price'], $_POST['service']);
  }

  if(isset($_POST['recommend'])){
    $recommendFriend = $_POST['friendSelection'];
    $user->recommendTo($recommendFriend, $visitedPlace);
  }

  
?>

<div class="jumbotron">
  <h1 class="display-4"><?php echo $visitedPlace->getName(); ?></h1>
  <p class="lead">
    <?php $visitedPlace->printTypes(); ?>
    <div class="container">
      <ul class="list-group">
        <li class='list-group-item d-flex justify-content-between align-items-center'>
          <?php printModalButton("telephone-modal", "Telephones"); ?>
          <?php printModalButton("rate-modal", "Rate"); ?>
          <?php printModalButton("recommend-modal","Recommend To A Friend"); ?>
        </li>
        <li class='list-group-item d-flex justify-content-between align-items-center'>
          <?php $visitedPlace->printMayor(); ?>
        </li>
        <li class='list-group-item d-flex justify-content-between align-items-center'>
          <?php $visitedPlace->printPopularity(); ?>
        </li>
      </ul>
    </div>
 </p>
</div>


<div class="container">
  <?php
    $visitedPlace->printMenusForUser();
  ?>
</div>


<br>
<div class="container">
  <?php $visitedPlace->printComments($user); ?>
</div>

<?php
  printPlainModalTop("telephone-modal","Telephones");
  $visitedPlace->printTelephones();
  printPlainModalDown();

  printModalTop("rate-modal", "Rate");
  $visitedPlace->printRate($user);
  printModalDown("rate", "Rate");

  printModalTop("recommend-modal", "Recommend");
  $visitedPlace->printRecommend($user);
  printModalDown("recommend", "Recommend");
?>
<!-- content here -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
  </body>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
  <script src="like.js"></script>
</html>
