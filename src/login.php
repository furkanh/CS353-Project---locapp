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

    <nav class="navbar navbar-dark" style="background-color:#444444;">
      <span class="navbar-brand mb-0 h1">
      <a class="navbar-brand" href="index.php">
        <img src="./img/logo.png" width="111" height="40" class="d-inline-block align-top" alt="">
      </a>
      </span>
      <form class="form-inline" action="signup.php" method="post">
        <button class="btn btn-outline-success my-2 mr-sm-2" type="submit">Sign Up</button>
      </form>
    </nav>
<br><br><br>
  <!-- Form for log in -->
  <div class="container">
  <div class="jumbotron">
    <div class="container">
      <form action = "index.php" method="post">
        <div class="form-group">
          <label for="usernameField">Username</label>
          <input type="text" class="form-control" id="usernameField" name=username placeholder="Enter Username" required>
        </div>
        <div class="form-group">
          <label for="inputPassword">Password</label>
          <input type="password" class="form-control" id="inputPassword" name=password placeholder="Password" required>
        </div>

          <?php
          if(isset($_GET["loginfail"])){
            if($_GET["loginfail"]==1){
              echo "<div class=\"alert alert-warning\" role=\"alert\"> Your username/password is wrong. </div>";
            }
            elseif($_GET["loginfail"]==2){
              echo "<div class=\"alert alert-success\" role=\"alert\"> Logged out. </div>";
            }
            elseif ($_GET["loginfail"]==3) {
              echo "<div class=\"alert alert-danger\" role=\"alert\"> Connection failed. </div>";
            }
          }
          ?>
          <button type="submit" class="btn btn-success">Log In</button>
    </form>


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
