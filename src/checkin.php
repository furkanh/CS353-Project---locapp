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
      $warning = false;
      if(isset($_POST['selection'])){
        $place = new Place($_POST['selection']);
        if(isset($_POST['gotoplace'])){
          $placeID = $place->getPlaceID();
          header("Location:place.php?place=$placeID");
          exit();
        }
        elseif (isset($_POST['checkin'])) {
          $postString = $_POST['postString'];
          if($postString!="" && strlen($postString)<=255){
            $user->checkIn($place->getPlaceID(), $postString);
          }
          else {
            $warning = true;
          }
        }
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
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <?php
        if($user->isPlaceOwner()){
          echo "<li class='nav-item'>
            <a class='nav-link' href='myplaces.php'>My Places</a>
            </li>";
        }
      ?>
      <li class="nav-item">
        <a class="nav-link active" href="checkin.php">Check-In <span class="sr-only">(current)</span></a>
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
<!-- coordinates for Yasamkent 39.9117,32.8403 -->
<!-- coordinates for Bilkent 39.8595,32.7423 -->
<?php

?>
<div class="container">
  <div class="jumbotron">
  <div class="container">
    <?php
      if($warning){
        echo "<div class='alert alert-danger' role='alert'> Your post cannot be more than 255 characters and empty. </div>";
      }
    ?>
    <div class="row">
      <form class="form-inline my-2 my-lg-0" method="post" action="checkin.php">
        <input class="form-control mr-sm-2" type="search" placeholder="Search for a place" aria-label="Search" name=search>
        <button class="btn btn-outline-success my-2 mr-sm-2" type="submit">Search</button>
      </form>

    </div>
    <?php
      $radius = 0.01;
      if(isset($_COOKIE['radius']) && isset($_POST['enlargeperimeter'])){
        $radius = $_COOKIE['radius'];
        $radius += 0.01;
        setcookie("radius", $radius, time()+300);
      }
      else {
        setcookie("radius", $radius, time()+300);
      }
      if(isset($_POST['search'])){
        $details = json_decode(file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}/json"));
        $loc = $details->loc;
        $locArr = explode(',', $loc);
        $lat = (float)$locArr[0];
        $lon = (float)$locArr[1];
        $db = new Database();
        $mysqli = $db->getConnection();
        $placeName = $_POST['search'];
        $sql = "SELECT * FROM place WHERE ABS($lat-lat)<=$radius AND ABS($lat-lat)<=$radius AND name like '%$placeName%';";
        if($table = $mysqli->query($sql)){
          echo "<form method='post'><div class='row'><div class='form-group'>";
          echo  "<label>Select a place</label><select class='form-control' name=selection>";
          while($row = $table->fetch_row()){
            echo "<option value=$row[0]>$row[1]</option>";
          }
          echo "</select>";
          echo "<button class='btn btn-outline-primary my-4 mr-sm-2' type='submit' name=gotoplace>Go to place</button>";
          echo "</div></div><div class='row'>";
          echo "<textarea class='form-control' rows='2' placeholder='What you are doing?' name=postString></textarea>";
          echo "</div><div class='row'>";
          echo "<button class='btn btn-outline-primary my-4 mr-sm-2' type='submit' name=checkin>Check In</button>";
          echo "</form>";
          echo "</div>";
          echo "<div class='row'>";
          echo "<form method='post'>";
          echo "<button class='btn btn-outline-success my-2 mr-sm-2' type='submit' name=enlargeperimeter>Enlarge Perimeter</button>";
          if(isset($_POST['search'])){
            $search = $_POST['search'];
            echo "<input type='hidden' name=search value='$search'></input>";
          }
          echo "</form></div>";
        }
      }
    ?>
  </div>
  </div>
</div>

<!-- content here -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
  </body>
</html>
