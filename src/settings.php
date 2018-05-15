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

      $username = "";
      $password = "";
      $email = "";
      $name = "";
      $surname = "";
      $bday = "";
      $usernameExists = false;
      if(isset($_POST['update'])){
        $username = $_POST['updatedUsername'];
        $password = $_POST['updatedPassword'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $bday = $_POST['bday'];

        $db = new Database();

        $mysqli = $db->getConnection();

        if ($mysqli->connect_errno) {
          //loginfail 3 is connection error
          header("Location:settings.php");
          exit();
        }

        $sql = "SELECT username FROM userpass WHERE username='$username';";
        $usernameExists = false;
        $table = $mysqli->query($sql);
        if($table->fetch_row()!=null && $username!=$user->getUsername()){
          //username exists
          $usernameExists = true;
        }
        else{
          //username does not exists
          //update
          $oldUsername = $user->getUsername();
          $sql = "UPDATE user SET username='$username', password='$password', email='$email', name='$name', surname='$surname', bday='$bday' WHERE username='$oldUsername';";
          $mysqli->query($sql);
          //set username password to cookies
          setcookie("username", $username, time()+1800); //cookie for 30 minutes
          setcookie("password", $password, time()+1800); //cookie for 30 minutes

          header("Location:settings.php");
          exit();
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
        <a class="nav-link" href="index.php">Home </a>
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
      <li class="nav-item active">
        <a class="nav-link" href="settings.php">Settings <span class="sr-only">(current)</span></a>
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

<!-- Form for update -->
<div class="container">
<div class="jumbotron">
  <div class="container">
    <form class="needs-validation" novalidate method="post">
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Username</label>
            <input type='text' class='form-control' name=updatedUsername placeholder='Username' value='<?php echo $user->getUsername(); ?>' required>
              <?php
              if($usernameExists){
                echo "<small class='form-text text-danger'>";
                echo "This username exists.";
                echo "</small>";
              }
              else {
                echo "<div class='invalid-feedback'>";
                echo "Choose a username.";
                echo "</div>";
              }
            ?>
        </div>
        <div class="col-md-6 mb-3">
          <label>Password</label>
          <input type="password" class="form-control" name=updatedPassword placeholder="Password" value='<?php echo $user->getPassword(); ?>' required>
          <div class="invalid-feedback">
            Please choose a password.
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>E-mail</label>
          <div class="input-group">
            <input type="email" class="form-control" name=email placeholder="email@example.com" value='<?php echo $user->getEmail(); ?>' required>
            <div class="invalid-feedback">
              Please enter a valid e-mail.
            </div>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Name</label>
          <div class="input-group">
            <input type="text" class="form-control" name=name placeholder="First Name" value='<?php echo $user->getName(); ?>' required>
            <div class="invalid-feedback">
              Enter your name.
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label>Last Name</label>
          <input type="text" class="form-control" name=surname placeholder="Last Name" value='<?php echo $user->getSurname(); ?>' required>
          <div class="invalid-feedback">
            Enter your last name.
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Birth Day</label>
          <div class="input-group">
            <input type="date" class="form-control" name=bday placeholder="DD-MM-YYY" value='<?php echo $user->getBirthday(); ?>' required>
            <div class="invalid-feedback">
              Enter your birthday.
            </div>
          </div>
        </div>
      </div>
      <br>
      <button class="btn btn-primary" type="submit" name=update>Update</button>
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
