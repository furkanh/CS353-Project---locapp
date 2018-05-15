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
      if(isset($_GET['place'])){
        $place = new Place($_GET['place']);
      }
      else{
        header("Location:index.php");
        exit();
      }

      if(!$user->ownsPlace($place)){
        header("Location:index.php");
        exit();
      }

      if(isset($_POST['update'])){
        $db = new Database();
        $mysqli = $db->getConnection();
        $placename = $_POST['placename'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $region = $_POST['region'];
        $loc = $_POST['location'];
        $locArr = explode(',', $loc);
        $lat = (float)$locArr[0];
        $lon = (float)$locArr[1];
        $placeID = $place->getPlaceID();
        $sql = "UPDATE place SET name='$placename', city='$city', country='$country', region='$region', lat=$lat, lon=$lon WHERE placeID=$placeID;";
        $mysqli->query($sql);
        header("Location:placesettings.php?place=$placeID");
        exit();
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

<?php
  $details = json_decode(file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}/json"));
?>
<!-- Form for create place -->
<div class="container">
<div class="jumbotron">
  <div class="container">
    <form class="needs-validation" novalidate method="post">
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Place Name</label>
            <input type='text' class='form-control' name=placename placeholder='Burger House' value='<?php echo $place->getName(); ?>' required>
            <div class='invalid-feedback'> Choose a place name. </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>City</label>
            <input type='text' class='form-control' name=city value='<?php
                if(isset($_POST['findlocation'])){
                  echo $details->city;
                }
                else{
                  echo $place->getCity();
                }
            ?>' required>
            <div class='invalid-feedback'> Choose a city. </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Region</label>
            <input type='text' class='form-control' name=region value='<?php
                if(isset($_POST['findlocation'])){
                  echo $details->region;
                }
                else{
                  echo $place->getRegion();
                }
            ?>' required>
            <div class='invalid-feedback'> Choose a region. </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Country</label>
            <input type='text' class='form-control' name=country value='<?php
                if(isset($_POST['findlocation'])){
                  echo $details->country;
                }
                else{
                  echo $place->getCountry();
                }
              ?>' required>
            <div class='invalid-feedback'> Choose a country. </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Location</label>
          <input type='text' class='form-control' name=location value='<?php
              if(isset($_POST['findlocation'])){
                echo $details->loc;
              }
              else{
                echo $place->getLocation();
              }
          ?>' required>
            <div class='invalid-feedback'> Choose a location. </div>
        </div>
      </div>
      <br>
      <button class="btn btn-primary" type="submit" name=update>Update</button>
      <button class="btn btn-primary" type="submit" name=findlocation>Find My Address</button>
      <a class="btn btn-warning" type="button" href="menus.php?place=<?php echo $place->getPlaceID(); ?>">Manage Menus</a>
      <a class="btn btn-warning" type="button" href="types.php?place=<?php echo $place->getPlaceID(); ?>">Manage Types</a>
      <a class="btn btn-warning" type="button" href="telnumbers.php?place=<?php echo $place->getPlaceID(); ?>">Manage Telephone Numbers</a>
    </form>
    <br>
    <?php
      if(!$user->isPlaceOwner()){
        echo "<a class='btn btn-warning' type='button' href='myplaces.php'>Become a Place Owner</a>";
      }
    ?>
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    </script>


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
