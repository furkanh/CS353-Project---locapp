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

    <!-- navbar for title -->
    <nav class="navbar navbar-dark bg-dark">
      <span class="navbar-brand mb-0 h1">Sign Up</span>
      <form class="form-inline" action="login.php" method="post">
        <button class="btn btn-outline-success my-2 mr-sm-2" type="submit">Back</button>
      </form>
    </nav>
<br>
<?php
include('database.php');
$username = "";
$password = "";
$email = "";
$name = "";
$surname = "";
$bday = "";
$usernameExists = false;
if(isset($_POST['signup'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $bday = $_POST['bday'];

  $db = new Database();

  $mysqli = $db->getConnection();

  if ($mysqli->connect_errno) {
    //loginfail 3 is connection error
    header("Location:signup.php");
    exit();
  }

  $sql = "SELECT username FROM userpass WHERE username='$username';";

  $table = $mysqli->query($sql);
  if($table->fetch_row()!=null){
    //username exists
    $usernameExists = true;
  }
  else{
    //username does not exists
    //sign up the user
    $sql = "INSERT INTO user(username, password, email, name, surname, bday) VALUES ".
      "('$username', '$password', '$email', '$name', '$surname', '$bday');";
    $mysqli->query($sql);
    //set username password to cookies
    setcookie("username", $username, time()+1800); //cookie for 30 minutes
    setcookie("password", $password, time()+1800); //cookie for 30 minutes
    //navigate to index.php
    header("Location:index.php");
    exit();
  }
}
 ?>
  <!-- Form for sign up -->
  <div class="container">
  <div class="jumbotron">
    <div class="container">
      <form class="needs-validation" novalidate method="post">
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label>Username</label>
              <input type='text' class='form-control' name=username placeholder='Username' value='<?php echo $username; ?>' required>
                <?php
                if($usernameExists){
                  $username = $_POST['username'];
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
            <input type="password" class="form-control" name=password placeholder="Password" value='<?php echo $password; ?>' required>
            <div class="invalid-feedback">
              Please choose a password.
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label>E-mail</label>
            <div class="input-group">
              <input type="email" class="form-control" name=email placeholder="email@example.com" value='<?php echo $email; ?>' required>
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
              <input type="text" class="form-control" name=name placeholder="First Name" value='<?php echo $name; ?>' required>
              <div class="invalid-feedback">
                Enter your name.
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label>Last Name</label>
            <input type="text" class="form-control" name=surname placeholder="Last Name" value='<?php echo $surname; ?>' required>
            <div class="invalid-feedback">
              Enter your last name.
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label>Birth Day</label>
            <div class="input-group">
              <input type="date" class="form-control" name=bday placeholder="DD-MM-YYY" value='<?php echo $date; ?>' required>
              <div class="invalid-feedback">
                Enter your birthday.
              </div>
            </div>
          </div>
        </div>
        <br>
        <button class="btn btn-primary" type="submit" name=signup>Sign Up</button>
      </form>

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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
  </body>
</html>
