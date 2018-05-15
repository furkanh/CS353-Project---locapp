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
      $place = null;
      $menuID = null;
      if(isset($_GET['place']) && isset($_GET['menu'])){
        $place = new Place($_GET['place']);
        $menuID = $_GET['menu'];
      }
      else{
        header("Location:index.php");
        exit();
      }

      if(!$user->ownsPlace($place)){
        header("Location:index.php");
        exit();
      }

      if(isset($_POST['deleteProduct'])){
        $place->deleteProduct($menuID, $_POST['deleteProduct']);
      }

      if(isset($_POST['addProduct'])){
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $place->addProduct($menuID, $productName, $price);
      }
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
<br>
<?php
  $place->printProducts($menuID, true);
?>



<!-- content here -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
  </body>
</html>
