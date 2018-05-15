<?php
  function printModalTop($modalID, $modalTitle){
    echo "<div class='modal fade' id='$modalID' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLongTitle'>$modalTitle</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
          <div class='form-group'><form method='post'>";
  }

  function printModalDown($buttonName, $buttonText){
    echo "  </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
          <button type='submit' class='btn btn-primary' name=$buttonName>$buttonText</button>
          </div>
        </form>
      </div>
    </div>
  </div></div>";
  }

  function printModalButton($modalID, $buttonText){
    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#$modalID'>
      $buttonText
    </button>";
  }

  function printModalLink($modalID, $linkText, $id){
    echo "<a data-toggle='modal' data-target='#$modalID' id='$id'>
      $linkText
    </a>";
  }

  function printPlainModalTop($modalID, $modalTitle){
    echo "<div class='modal fade' id='$modalID' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLongTitle'>$modalTitle</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
          <div class='form-group'>";
  }

  function printPlainModalDown(){
    echo "  </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
      </div>
      </div>
    </div>
  </div></div>";
  }

  function calculateTimeAgo($datetime){
    $timeAgo = time()-(strtotime($datetime)-11200+360+40);
    if($timeAgo<60){
      return "$timeAgo seconds ago";
    }
    elseif ($timeAgo<60*60) {
      $timeAgo = floor($timeAgo/60);
      if($timeAgo==1){
        return "$timeAgo minute ago";
      }
      else {
        return "$timeAgo minutes ago";
      }
    }
    elseif ($timeAgo<60*60*24) {
      $timeAgo = floor($timeAgo/(60*60));
      if($timeAgo==1){
        return "$timeAgo hour ago";
      }
      else {
        return "$timeAgo hours ago";
      }
    }
    else {
      $timeAgo = floor($timeAgo/(60*60*24));
      if($timeAgo==1){
        return "$timeAgo day ago";
      }
      else {
        return "$timeAgo days ago";
      }
    }
  }

  class Checkin{
    public static function getNumOfLikes($username, $placeID, $datetime){
      $db = new Database();
      $mysqli = $db->getConnection();
      $sql = "SELECT * FROM checkin A, likecheckin B WHERE A.placeID=$placeID AND A.datetime='$datetime' AND A.username='$username' AND A.username=B.username_r AND A.placeID=B.placeID AND A.datetime=B.datetime;";
      $numOfLikes = 0;
      if($likesTable = $mysqli->query($sql)){
        $numOfLikes = $likesTable->num_rows;
      }
      return $numOfLikes;
    }
  }

  class Comment{
    public static function getNumOfLikes($placeID, $commentID){
      $db = new Database();
      $mysqli = $db->getConnection();
      $sql = "SELECT * FROM likecomment WHERE placeID=$placeID AND commentID=$commentID;";
      $numOfLikes = 0;
      if($likesTable = $mysqli->query($sql)){
        $numOfLikes = $likesTable->num_rows;
      }
      return $numOfLikes;
    }
  }

  class Place{
    private $placeID;
    private $db;

    public function __construct($placeID){
      $this->placeID = $placeID;
      $this->db = new Database();
      $mysqli = $this->db->getConnection();
      if(!$this->doesExist()){
        header("Location:index.php");
        exit();
      }
    }

    public function doesExist(){
      $mysqli = $this->db->getConnection();
      //query for username and password
      $sql = "SELECT * FROM place WHERE placeID=$this->placeID;";
      $table = $mysqli->query($sql);
      if($table->fetch_row()==null){
        return false;
      }
      return true;
    }

    public function getPlaceID(){
      return $this->placeID;
    }

    public function getLat(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT lat FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return null;
    }

    public function getLon(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT lon FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return null;
    }

    public function getLocation(){
      $lat = $this->getLat();
      $lon = $this->getLon();
      if($lat!=null & $lon!=null){
        return $lat.",".$lon;
      }
      return null;
    }

    public function getCity(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT city FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return null;
    }

    public function getCountry(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT country FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return null;
    }

    public function getRegion(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT region FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return null;
    }

    public function getName(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT name FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return null;
    }

    public function deleteMenu($menuID){
      $mysqli = $this->db->getConnection();
      $sql = "DELETE FROM menu WHERE placeID=$this->placeID AND menuID=$menuID;";
      $mysqli->query($sql);
    }

    //prints menu list
    public function printMenusForUser(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT placeID, menuID, menuName FROM menu WHERE placeID=$this->placeID;";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>";
      $placeName = $this->getName();
      echo "Menus for $placeName";
      $placeID = $this->getPlaceID();
      echo "</li>";
      $count = 0;
      echo "<li class='list-group-item d-flex align-items-center'>";
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
          printModalButton("$row[0]-modal", $row[2]);
        }
      }
      if($count==0){
        echo "This place doesn't have any menu.";
      }
      echo "</li>";
      echo "</ul></div>";
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          printPlainModalTop("$row[0]-modal", $row[2]);
          $this->printProducts($row[1]);
          printPlainModalDown();
        }
      }
    }

    public function printMenus(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT placeID, menuID, menuName FROM menu WHERE placeID=$this->placeID;";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>";
      $placeName = $this->getName();
      echo "Menus for $placeName";
      $placeID = $this->getPlaceID();
      printModalButton('createMenuModal', 'Create Menu');
      echo "</li>";
      $count = 0;
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
          echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
          echo "<a href='menu.php?place=$row[0]&menu=$row[1]'>$row[2]</a>";
          echo "<form method='post'>";
          echo "<button class='btn btn-danger' name=deleteMenu value=$row[1]>Delete</button>";
          echo "</form>";
          echo "</li>";
        }
      }
      if($count==0){
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "You have no menu.";
        echo "</li>";
      }
      echo "</ul></div>";
      printModalTop('createMenuModal', 'Create Menu');
      echo "<label for='menunameField'>Menu Name</label>
        <input type='text' class='form-control' id='menunameField' name=menuName placeholder='Enter Menu Name' required></input>";
      printModalDown('createmenu', 'Create');
    }

    public function getOwner(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT username FROM owns WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row=$table->fetch_row()){
          return $row[0];
        }
        return null;
      }
      return null;
    }

    public function createMenu($menuName){
      $mysqli = $this->db->getConnection();
      $username = $this->getOwner();
      $sql = "CALL insertMenu($this->placeID,'$menuName');";
      $mysqli->query($sql);
    }

    public function getMenuName($menuID){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT menuName FROM menu WHERE placeID=$this->placeID AND menuID=$menuID;";
      if($table = $mysqli->query($sql)){
        $row = $table->fetch_row();
        return $row[0];
      }
      return "";
    }

    public function printProducts($menuID, $isDeleteButtonActive = false){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT placeID, menuID, productID, name, price FROM product WHERE placeID=$this->placeID AND menuID=$menuID;";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>";
      $menuName = $this->getMenuName($menuID);
      $placeName = $this->getName();
      echo "Products for $menuName @$placeName";
      $placeID = $this->getPlaceID();
      if($isDeleteButtonActive){
        printModalButton('addProductModal', 'Add Product');
      }
      echo "</li>";
      $count = 0;
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
          echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
          echo "<h4>$row[3]</h4>";
          echo "<h4>$ $row[4]</h4>";
          if($isDeleteButtonActive){
            echo "<form method='post'>";
            echo "<button class='btn btn-danger' name=deleteProduct value=$row[2]>Delete</button>";
            echo "</form>";
          }
          echo "</li>";
        }
      }
      if($count==0){
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "This menu has no product";
        echo "</li>";
      }
      echo "</ul></div>";
      if($isDeleteButtonActive){
        printModalTop('addProductModal', 'Add Product');
        echo "<label for='menunameField'>Menu Name</label>
          <input type='text' class='form-control' name=productName placeholder='Wine' required></input>
          <input type='number' step=0.01 class='form-control' name=price placeholder='13.90' required></input>";
        printModalDown('addProduct', 'Add Product');
      }
    }

    public function addProduct($menuID, $productName, $price){
      $mysqli = $this->db->getConnection();
      $sql = "CALL insertProduct($this->placeID, $menuID, '$productName', $price);";
      $mysqli->query($sql);
    }

    public function deleteProduct($menuID, $productID){
      $mysqli = $this->db->getConnection();
      $sql = "DELETE FROM product WHERE placeID=$this->placeID AND menuID=$menuID AND productID=$productID;";
      $mysqli->query($sql);
    }

    public function printTelephones(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT telno FROM placetel WHERE placeID=$this->placeID;";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>";
      $placeName = $this->getName();
      echo "Telephone numbers for $placeName";
      $placeID = $this->getPlaceID();
      echo "</li>";
      $count = 0;
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
          echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
          echo "<h4>$row[0]</h4>";
          echo "</li>";
        }
      }
      if($count==0){
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "This place did not add any telephone number.";
        echo "</li>";
      }
      echo "</ul></div>";
    }

    public function printTelephonesForOwner(){
      $mysqli = $this->db->getConnection();
      if(isset($_POST['addTelephone'])){
        $telNo = $_POST['telephoneNum'];
        if($telNo){
          if(strlen($telNo)!=10 || !is_numeric($telNo)){
            echo "<div class='alert alert-danger' role='alert'> Telephone number should be 10 digit number. </div>";
          }
          else {
            $sql = "INSERT INTO placetel(placeID, telno) VALUES ($this->placeID, '$telNo');";
            $mysqli->query($sql);
          }
        }
      }
      if(isset($_POST['deleteTelephone'])){
        $telNo = $_POST['deleteTelephone'];
        $sql = "DELETE FROM placetel WHERE placeID=$this->placeID AND telno='$telNo';";
        $mysqli->query($sql);
      }
      $sql = "SELECT telno FROM placetel WHERE placeID=$this->placeID;";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>";
      $placeName = $this->getName();
      echo "Telephone numbers for $placeName";
      $placeID = $this->getPlaceID();
      printModalButton('addTelephoneModal', 'Add Telephone');
      echo "</li>";
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
          echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
          echo "<h4>$row[0]</h4>";
          echo "<form method='post'>";
          echo "<button class='btn btn-danger' name=deleteTelephone value='$row[0]'>Delete</button>";
          echo "</form>";
          echo "</li>";
        }
      }
      if($count==0){
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "This place did not add any telephone number.";
        echo "</li>";
      }
      echo "</ul></div>";
      printModalTop("addTelephoneModal", "Add Telephone");
      echo "<label>Menu Name</label>
        <input type='tel' class='form-control' name=telephoneNum placeholder='123-456-7890' required></input>";
      printModalDown("addTelephone","Add");
    }

    public function printTypes(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT typeName FROM placetype NATURAL JOIN type WHERE placeID=$this->placeID;";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item d-flex align-items-center'>";
      $count = 0;
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
            echo "<button type='button' class='btn btn-primary' data-toggle='modal'>$row[0]</button>";
        }
      }
      if($count==0){
        echo "This place has no type.";
      }
      echo "</li>";
      echo "</ul></div>";
    }

    public function getMayorUsername(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT mayorUsername FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
        return null;
      }
      return null;
    }

    public function printMayor(){
      $mayorUsername = $this->getMayorUsername();
      if($mayorUsername){
          echo "Mayor: $mayorUsername";
      }
      else{
        echo "Check in at this place to be the mayor at this place.";
      }
    }

    public function getPopularity(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT popularity FROM place WHERE placeID=$this->placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
        return null;
      }
      return null;
    }

    public function printPopularity(){
      $popularity = $this->getPopularity();
      if($popularity){
        echo "Popularity: $popularity";
      }
      else{
        echo "Rate this place.";
      }
    }

    public function printRate($user){
      $price = 5;
      $ambiance = 5;
      $service = 5;
      if($user->hasRated($this)){
        $mysqli = $this->db->getConnection();
        $username = $user->getUsername();
        $sql = "SELECT price, ambiance, service FROM rate WHERE username='$username' AND placeID=$this->placeID;";
        if($table = $mysqli->query($sql)){
          if($row = $table->fetch_row()){
            $price = $row[0];
            $ambiance = $row[1];
            $service = $row[2];
          }
        }
      }
      echo "<label>Service</label><input type='range' min='0' max='10' class='form-control' name=service value=$service></input>";
      echo "<label>Ambiance</label><input type='range' min='0' max='10' class='form-control' name=ambiance value=$ambiance></input>";
      echo "<label>Price</label><input type='range' min='0' max='10' class='form-control' name=price value=$price></input>";
    }

    public function printRecommend($user){
      $mysqli = $this->db->getConnection();
      $sql = $user->getFriendListQuery().";";
      if($table = $mysqli->query($sql)){
        echo  "<label>Select a friend</label><select class='form-control' name=friendSelection>";
        while($row = $table->fetch_row()){
          echo "<option value=$row[0]>$row[0]</option>";
        }
        echo "</select>";
      }
    }

    public function printCommentLikes($observer, $username, $commentID, $placeID){
      $observerUsername = $observer->getUsername();
      $sql = "SELECT username FROM likecomment WHERE username='$username' AND placeID=$placeID AND commentID=$commentID AND username<>'$observerUsername';";
      $mysqli = $this->db->getConnection();
      echo "<div class='container'>";
      echo "<div class='jumbotron'>";

      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          while($row = $table->fetch_row()){
            echo "<a href='profile.php?uname=$row[0]'>";
            echo $row[0];
            echo "</a>";
            echo "<hr class='my-4'>";
          }
        }
        else {
          echo "No likes to show.";
        }
      }
      echo "</div></div>";
    }

    public function printComments($observer, $numOfComments = null){
      $this->printCommentBox($observer);
      $mysqli = $this->db->getConnection();
      if($numOfComments==null){
        $sql = "SELECT placeID, commentID, username, commentString, datetime FROM comment WHERE placeID=$this->placeID ORDER BY datetime DESC;";
      }
      else {
        $sql = "SELECT placeID, commentID, username, commentString, datetime FROM comment WHERE placeID=$this->placeID ORDER BY datetime DESC LIMIT $numOfComments;";
      }
      echo "<div class='container'>";
      echo "<div class='jumbotron'>";
      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          while($row = $table->fetch_row()){
            //put primary key of comment to jump here later
            echo "<div class='container'>";
            echo "<ul>";
            echo "<a href='profile.php?uname=$row[2]'>";
            echo "<li class='d-flex justify-content-between'>";
            echo "<div><h4 class='display-10'>$row[2]</h4></div>";
            echo calculateTimeAgo($row[4]);
            echo "</li>";
            echo "</a>";
            echo "<li class='d-flex justify-content-between'>";
            echo "<p class='lead'>$row[3]</p>";
            echo "</li>";
            echo "<li class='d-flex justify-content-between'>";
            $numOfLikes = Comment::getNumOfLikes($row[0], $row[1]);
            printModalLink("$row[0]-$row[1]", "$numOfLikes Likes", "numOfLikesID-$row[0]-$row[1]");
            echo "</li>";
            echo "<li class='d-flex justify-content-between'>";
            $username = $observer->getUsername();
            if($observer->hasLikedComment($row[0], $row[1])){
              //jump to its placeholder after disliking
              echo "<button onclick='likeComment(\"$username\", $row[0], $row[1]);' class='btn btn-success btn-sm' id='likeCommentID-$row[0]-$row[1]' type='button'>Dislike</button>";
            }
            else {
              //jump to its placeholder after liking
              echo "<button onclick='likeComment(\"$username\", $row[0], $row[1]);' class='btn btn-outline-success btn-sm' id='likeCommentID-$row[0]-$row[1]' type='button'>Like</button>";
            }
            echo "</li>";
            echo "<hr class='my-4'>";
            echo "</ul></div>";
            printPlainModalTop("$row[0]-$row[1]", "Likes for $row[2]");
            //print who liked the checkin
            $this->printCommentLikes($observer, $row[2], $row[1], $row[0]);
            printPlainModalDown();
          }
        }
        else {
          echo "There are no comments.";
        }
      }
      echo "</div></div>";
    }

    public function printCommentBox($observer){
      if(isset($_POST['comment'])){
        $commentStr = $_POST['commentString'];
        if(strlen($commentStr)>255){
          echo "<div class='alert alert-danger' role='alert'> Your comment cannot be more than 255 characters. </div>";
        }
        else {
          $username = $observer->getUsername();
          $sql = "CALL insertComment($this->placeID, '$username', '$commentStr');";
          $mysqli = $this->db->getConnection();
          $mysqli->query($sql);
        }
      }
      echo "<div class='container'>";
      echo "<form method='post'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item d-flex align-items-center'>";
      echo "<textarea class='form-control' rows='3' placeholder='Comment on this place.' name=commentString required></textarea>";
      echo "</li>";
      echo "<li class='list-group-item d-flex flex-row-reverse'>";
      echo "<button class='btn btn-outline-primary my-4 mr-sm-2' type='submit' name=comment>Comment</button>";
      echo "</li>";
      echo "</ul></form></div>";
    }

    public function printTypesForPlaceOwner(){
      $mysqli = $this->db->getConnection();
      if(isset($_POST['deleteType'])){
        $typeID = $_POST['deleteType'];
        $sql = "DELETE FROM placetype WHERE placeID=$this->placeID AND typeID=$typeID;";
        $mysqli->query($sql);
      }
      $sql = "SELECT typeName, typeID FROM placetype NATURAL JOIN type WHERE placeID=$this->placeID;";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>";
      $placeName = $this->getName();
      echo "Types for $placeName";
      $placeID = $this->getPlaceID();
      echo "<a type='button' class='btn btn-primary' href='addtype.php?place=$this->placeID'>Add Type</a>";
      echo "</li>";
      $count = 0;
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
          echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
          echo "<h4>$row[0]</h4>";
          echo "<form method='post'>";
          echo "<button class='btn btn-danger' name=deleteType value=$row[1]>Delete</button>";
          echo "</form>";
          echo "</li>";
        }
      }
      if($count==0){
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "This place has no type.";
        echo "</li>";
      }
      echo "</ul></div>";
    }


  }

  class User{
    private $username;
    private $password;
    private $db;

    public function __construct($username = null){
      if(isset($_POST["logout"])){
        setcookie("username", $this->username, time()+1);
        setcookie("password", $this->password, time()+1);
        //login fail 2 log out
        header("Location:login.php?loginfail=2");
        exit();
      }
      $this->db = new Database();
      if($username==null){
        if(isset($_POST["username"]) && isset($_POST["password"])){
          $this->username = $_POST["username"];
          $this->password = $_POST["password"];
          setcookie("username", $this->username, time()+1800); //cookie for 30 minutes
          setcookie("password", $this->password, time()+1800); //cookie for 30 minutes
        }
        elseif (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
          $this->username = $_COOKIE["username"];
          $this->password = $_COOKIE["password"];
          setcookie("username", $this->username, time()+1800); //cookie for 30 minutes
          setcookie("password", $this->password, time()+1800); //cookie for 30 minutes
        }
        else {
          //login fail 0 connection time out or never logged in
          header("Location:login.php?loginfail=0");
          exit();
        }
      }
      else{
        $this->username = $username;
        $this->password = "";
        if(!$this->doesExist()){
          //login fail 1 wrong pass or username
          header("Location:index.php");
          exit();
        }
      }
    }

    public function getUsername(){
      return $this->username;
    }

    public function getPassword(){
      return $this->password;
    }

    public function getEmail(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT email FROM user WHERE username='$this->username';";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return "";
    }

    public function getName(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT name FROM user WHERE username='$this->username';";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return "";
    }

    public function getSurname(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT surname FROM user WHERE username='$this->username';";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return "";
    }

    public function getBirthday(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT bday FROM user WHERE username='$this->username';";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return $row[0];
        }
      }
      return "";
    }

    public function equals($user){
      if($user->getUsername()==$this->username){
        return true;
      }
      else{
        return false;
      }
    }

    public function doesExist(){
      $mysqli = $this->db->getConnection();
      //query for username and password
      $sql = "SELECT * FROM userpass WHERE username='$this->username';";
      $table = $mysqli->query($sql);
      if($table->fetch_row()==null){
        return false;
      }
      return true;
    }

    public function authenticate(){
      $mysqli = $this->db->getConnection();
      //query for username and password
      $sql = "SELECT * FROM userpass WHERE username='$this->username' AND password='$this->password';";
      $table = $mysqli->query($sql);
      if($table->fetch_row()==null){
        //login fail 1 wrong pass or username
        header("Location:login.php?loginfail=1");
        exit();
      }
      $table->close();
    }

    public function getNumOfNotifications(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT username_s FROM friendrequest WHERE username_r='$this->username'";
      $num = 0;
      if($table = $mysqli->query($sql)){
        $num += $table->num_rows;
      }
      $sql = "SELECT * FROM recommend WHERE username_r='$this->username';";
      if($table = $mysqli->query($sql)){
        $num += $table->num_rows;
      }
      return $num;
    }

    public function printRecommendNotifications(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT username_s, placeID, datetime FROM recommend WHERE username_r='$this->username';";
      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          echo "<div class='jumbotron'>";
          while($row = $table->fetch_row()){
            $place = new Place($row[1]);
            $placeName = $place->getName();
            $time = calculateTimeAgo($row[2]);
            echo "<h4 class='display-10' ><a href='profile.php?uname=$row[0]'>$row[0]</a> recommended you to visit</p>";
            echo "<h4 class='display-10' ><a href='place.php?place=$row[1]'>$placeName</a></p>";
            echo "<h4 class='display-10' >$time</p>";
            echo "<hr class='my-4'>";
          }
          echo "</div>";
          return true;
        }
        else {
          return false;
        }
      }
      return false;
    }

    public function printNotifications(){
      if(!$this->printFriendRequests() & !$this->printRecommendNotifications()){
        echo "There are no notifications.";
      }
    }

    public function printFriendRequests(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT username_s FROM friendrequest WHERE username_r='$this->username'";
      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          echo "<div class='jumbotron'>";
          while($row = $table->fetch_row()){
            echo "<h4 class='display-10' ><a href='profile.php?uname=$row[0]'>$row[0]</a></p>";
            echo "<form class='form-inline my-2 my-lg-0' method='post'>";
            echo "<input type='hidden' name=addedusername value='$row[0]'></input>";
            echo "<button class='btn btn-outline-success' type='submit' name=acceptrequestmodal>Accept</button>";
            echo "<button class='btn btn-outline-danger' type='submit' name=rejectrequestmodal>Reject</button>";
            echo "</form>";
            echo "<hr class='my-4'>";
          }
          echo "</div>";
          return true;
        }
        else {
          return false;
        }
      }
      return false;
    }

    public function isPlaceOwner(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT isPlaceOwner FROM user WHERE username='$this->username';";
      $table = $mysqli->query($sql);
      $isPlaceOwner = $table->fetch_row();
      if($isPlaceOwner[0]==1){
        return true;
      }
      return false;
    }

    public function getTravelPoints(){
      $mysqli = $this->db->getConnection();
      $points = 0;
      $CHECKIN_COEF = 12;
      $COMMENT_COEF = 3;
      $sql = "SELECT count(*) FROM checkin WHERE username='$this->username';";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          $points += $row[0]*$CHECKIN_COEF;
        }
      }
      $table->close();
      $sql = "SELECT count(*) FROM comment WHERE username='$this->username';";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          $points += $row[0]*$COMMENT_COEF;
        }
      }
      $table->close();
      return $points;
    }

    public function isFriendWith($user){
      $mysqli = $this->db->getConnection();
      $username = $user->getUsername();
      $sql = "SELECT * FROM friend WHERE (username_s='$username' AND username_r='$this->username') OR (username_r='$username' AND username_s='$this->username');";
      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          return true;
        }
        else {
          return false;
        }
      }
      else{
        return false;
      }
    }

    public function hasLikedCheckin($username, $placeID, $datetime){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT * FROM checkin A, likecheckin B WHERE A.placeID=$placeID AND A.datetime='$datetime' AND A.username='$username' AND A.username=B.username_r AND A.placeID=B.placeID AND A.datetime=B.datetime AND B.username_s='$this->username';";
      if($likesTable = $mysqli->query($sql)){
        if($likesTable->num_rows>0){
          return true;
        }
        return false;
      }
      return false;
    }

    public function getFriendListQuery(){
      return "SELECT username_s as username FROM friend WHERE username_r='$this->username' UNION SELECT username_r as username FROM friend WHERE username_s='$this->username'";
    }

    public function getFriendListQueryWithMe(){
      return "SELECT username_s as username FROM friend WHERE username_r='$this->username' UNION SELECT username_r as username FROM friend WHERE username_s='$this->username' UNION SELECT username FROM user WHERE username='$this->username'";
    }

    public function printCheckInLikes($observer, $username, $placeID, $datetime){
      $observerUsername = $observer->getUsername();
      $sql = "SELECT username_s FROM likecheckin WHERE username_r='$username' AND placeID=$placeID AND datetime='$datetime' AND username_s<>'$observerUsername';";
      $mysqli = $this->db->getConnection();
      echo "<div class='container'>";
      echo "<div class='jumbotron'>";

      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          while($row = $table->fetch_row()){
            echo "<a href='profile.php?uname=$row[0]'>";
            //echo "<div><h4 class='display-10'>$row[0]</h4></div>";
            echo $row[0];
            echo "</a>";
            echo "<hr class='my-4'>";
          }
        }
        else {
          echo "No likes to show.";
        }
      }
      echo "</div></div>";
    }

    private function printCheckIns($observer, $sql){
      $mysqli = $this->db->getConnection();
      echo "<div class='container'>";
      echo "<div class='jumbotron'>";
      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          while($row = $table->fetch_row()){
            //put primary key of checkin to jump here later
            echo "<a name='$row[0]-$row[1]-$row[3]'>";
            echo "<div class='container'>";
            echo "<ul>";
            echo "<a href='profile.php?uname=$row[0]'>";
            echo "<li class='d-flex justify-content-between'>";
            echo "<div><h4 class='display-10'>$row[0]</h4></div>";
            echo calculateTimeAgo($row[3]);
            echo "</li>";
            echo "</a>";
            echo "<a href='place.php?place=$row[1]'>";
            echo "<li class='d-flex justify-content-between'>";
            echo "<div><h4 class='display-10'>@$row[2]</h4></div>";
            echo "</li>";
            echo "</a>";
            echo "<li class='d-flex justify-content-between'>";
            echo "<p class='lead'>$row[4]</p>";
            echo "</li>";
            echo "<li class='d-flex justify-content-between'>";
            $time = strtotime($row[3]);
            $numOfLikes = Checkin::getNumOfLikes($row[0],$row[1],$row[3]);
            printModalLink("$row[0]-$row[1]-$time", "$numOfLikes Likes", "numOfLikesID-$row[0]-$row[1]-$time");
            echo "<br>";
            echo "</li>";
            echo "<li class='d-flex justify-content-between'>";
            $observerUsername = $observer->getUsername();
            if($observer->hasLikedCheckin($row[0], $row[1], $row[3])){
              //jump to its placeholder after disliking
              echo "<button onclick='likeCheckIn(\"$observerUsername\",\"$row[0]\", $row[1], \"$row[3]\", \"$time\");' class='btn btn-success btn-sm' id='likeCheckInID-$row[0]-$row[1]-$time' type='button'>Dislike</button>";
            }
            else {
              //jump to its placeholder after liking
              echo "<button onclick='likeCheckIn(\"$observerUsername\",\"$row[0]\", $row[1], \"$row[3]\", \"$time\");' id='likeCheckInID-$row[0]-$row[1]-$time' class='btn btn-outline-success btn-sm' type='button'>Like</button>";
            }
            echo "</li>";
            echo "<hr class='my-4'>";
            echo "</ul>";
            echo "</div>";
            printPlainModalTop("$row[0]-$row[1]-$time", "Likes for $row[0]");
            //print who liked the checkin
            $this->printCheckInLikes($observer, $row[0], $row[1], $row[3]);
            printPlainModalDown();
          }
          echo "<form method='post'>";
          echo "<center>";
          echo "<button class='btn btn-success btn-sm' type='submit' name=loadmore>Load More</button>";
          echo "</center>";
          echo "</form>";
        }
        else {
          echo "There are no check-ins.";
        }
      }
      echo "</div></div>";
    }

    public function printUserCheckIns($observer, $numOfCheckIns = null){
      if($numOfCheckIns==null){
        $sql = "SELECT username, placeID, name, datetime, postString FROM checkin NATURAL JOIN placename WHERE username='$this->username' ORDER BY datetime DESC;";
      }
      else{
        $sql = "SELECT username, placeID, name, datetime, postString FROM checkin NATURAL JOIN placename WHERE username='$this->username' ORDER BY datetime DESC LIMIT $numOfCheckIns;";
      }
      $this->printCheckIns($observer, $sql);
    }

    public function printAllCheckIns($numOfCheckIns = null){
      $friendListQuery = $this->getFriendListQueryWithMe();
      if($numOfCheckIns==null){
        $sql = "SELECT username, placeID, name, datetime, postString FROM (checkin NATURAL JOIN placename) NATURAL JOIN ($friendListQuery) AS friendList ORDER BY datetime DESC;";
      }
      else{
        $sql = "SELECT username, placeID, name, datetime, postString FROM (checkin NATURAL JOIN placename) NATURAL JOIN ($friendListQuery) AS friendlist ORDER BY datetime DESC LIMIT $numOfCheckIns;";
      }
      $this->printCheckIns($this, $sql);
    }

    public function likeCheckIn($username, $placeID, $datetime){
      $sql = "INSERT INTO likecheckin VALUES ('$this->username', '$username', $placeID, '$datetime');";
      $mysqli = $this->db->getConnection();
      $mysqli->query($sql);
    }

    public function dislikeCheckIn($username, $placeID, $datetime){
      $sql = "DELETE FROM likecheckin WHERE username_s='$this->username' AND username_r='$username' AND placeID=$placeID AND datetime='$datetime';";
      $mysqli = $this->db->getConnection();
      $mysqli->query($sql);
    }

    public function likeComment($placeID, $commentID){
      $sql = "INSERT INTO likecomment(username, commentID, placeID) VALUES ('$this->username', $commentID, $placeID);";
      $mysqli = $this->db->getConnection();
      $mysqli->query($sql);
    }

    public function dislikeComment($placeID, $commentID){
      $sql = "DELETE FROM likecomment WHERE username='$this->username' AND placeID=$placeID AND commentID = $commentID;";
      $mysqli = $this->db->getConnection();
      $mysqli->query($sql);
    }

    public function hasReceivedFriendRequestFrom($user){
      $mysqli = $this->db->getConnection();
      $username = $user->getUsername();
      $sql = "SELECT * FROM friendrequest WHERE username_r='$this->username' AND username_s='$username';";
      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          return true;
        }
        else {
          return false;
        }
      }
      else{
        return false;
      }
    }

    public function deleteFriend($user){
      //this user deletes user
      $mysqli = $this->db->getConnection();
      $username = $user->getUsername();
      $sql = "DELETE FROM friend WHERE username_r='$username' AND username_s='$this->username' OR username_s='$username' AND username_r='$this->username';";
      $mysqli->query($sql);
    }

    public function acceptRequest($user){
      //this user accepts request from user
      $mysqli = $this->db->getConnection();
      $username = $user->getUsername();
      $sql = "INSERT INTO friend(username_r, username_s) VALUES ('$username', '$this->username');";
      $mysqli->query($sql);
    }

    public function rejectRequest($user){
      //this user rejects request from user
      $mysqli = $this->db->getConnection();
      $username = $user->getUsername();
      $sql = "DELETE FROM friendrequest WHERE username_r='$this->username' AND username_s='$username';";
      $mysqli->query($sql);
    }

    public function addFriend($user){
      //this user sends request to user
      $mysqli = $this->db->getConnection();
      $username = $user->getUsername();
      $sql = "INSERT INTO friendrequest(username_r, username_s) VALUES ('$username', '$this->username');";
      $mysqli->query($sql);
    }

    public function setPlaceOwner($num){
      $mysqli = $this->db->getConnection();
      $sql = "UPDATE user SET isPlaceOwner=$num WHERE username='$this->username';";
      $mysqli->query($sql);
    }

    public function printPlaces(){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT placeID, name FROM owns NATURAL JOIN place WHERE username='$this->username';";
      echo "<div class='container'>";
      echo "<ul class='list-group'>";
      echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>";
      echo "Places";
      echo "<a type='button' class='btn btn-primary' href='createplace.php'>Create Place</a>";
      echo "</li>";
      $count = 0;
      if($table = $mysqli->query($sql)){
        while($row=$table->fetch_row()){
          $count++;
          echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
          echo "<a href='place.php?place=$row[0]'>$row[1]</a>";
          echo "<form method='post'>";
          echo "<a type='button' class='btn btn-success' href='placesettings?place=$row[0]'>Settings</a>";
          echo "<button class='btn btn-warning' name=removePlace value=$row[0]>Remove</button>";
          echo "<button class='btn btn-danger' name=deletePlace value=$row[0]>Delete</button>";
          echo "</form>";
          echo "</li>";
        }
      }
      if($count==0){
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "You have no place.";
        echo "</li>";
      }
      echo "</ul></div>";
    }

    public function deletePlace($placeID){
      $mysqli = $this->db->getConnection();
      $sql = "DELETE FROM place WHERE placeID=$placeID;";
      $mysqli->query($sql);
    }

    public function removePlace($placeID){
      $mysqli = $this->db->getConnection();
      $sql = "DELETE FROM owns WHERE placeID=$placeID AND username='$this->username';";
      $mysqli->query($sql);
    }

    public function ownsPlace($place){
      $mysqli = $this->db->getConnection();
      $placeID = $place->getPlaceID();
      $sql = "SELECT * FROM owns WHERE placeID=$placeID AND username='$this->username'";
      $table = $mysqli->query($sql);
      if($table->fetch_row()==null){
        return false;
      }
      return true;
    }

    public function checkIn($placeID, $postString){
      $mysqli = $this->db->getConnection();
      $sql = "INSERT INTO checkin(username, placeID, postString) VALUES ('$this->username', $placeID, '$postString');";
      $mysqli->query($sql);
    }

    public function hasRated($place){
      $mysqli = $this->db->getConnection();
      $placeID = $place->getPlaceID();
      $sql = "SELECT * FROM rate WHERE username='$this->username' AND placeID=$placeID;";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return true;
        }
        return false;
      }
      return false;
    }

    public function ratePlace($place, $ambiance, $price, $service){
      $mysqli = $this->db->getConnection();
      $sql = "";
      $placeID = $place->getPlaceID();
      if($this->hasRated($place)){
        $sql = "UPDATE rate SET ambiance=$ambiance, price=$price, service=$service WHERE username='$this->username' AND placeID=$placeID;";
      }
      else {
        $sql = "INSERT INTO rate(username, placeID, price, ambiance, service) VALUES ('$this->username', $placeID, $price, $ambiance, $service);";
      }
      $mysqli->query($sql);
    }

    public function recommendTo($recommendFriend, $place){
      $mysqli = $this->db->getConnection();
      $placeID = $place->getPlaceID();
      if($recommendFriend){
        $sql = "INSERT INTO recommend(username_s, username_r, placeID) VALUES ('$this->username', '$recommendFriend', $placeID);";
        $mysqli->query($sql);
      }
    }

    public function hasLikedComment($placeID, $commentID){
      $mysqli = $this->db->getConnection();
      $sql = "SELECT * FROM likecomment WHERE placeID=$placeID AND commentID=$commentID AND username='$this->username';";
      if($table = $mysqli->query($sql)){
        if($row = $table->fetch_row()){
          return true;
        }
        return false;
      }
      return false;
    }

    public function printMessagesWith($chatUser){
      $mysqli = $this->db->getConnection();
      $chatUsername = $chatUser->getUsername();
      $sql = "SELECT username_s, username_r, datetime, messageStr FROM message WHERE username_r='$this->username' AND username_s='$chatUsername' OR username_s='$this->username' AND username_r='$chatUsername' ORDER BY datetime ASC;";
      if($table = $mysqli->query($sql)){
        if($table->num_rows>0){
          while($row = $table->fetch_row()){
            echo "$row[0] [$row[2]]:";
            echo "$row[3] \n\n";
          }
        }
        else {
          echo "No messages.";
        }
      }
      else {
        echo "Connection error. Try again.";
      }
    }

    public function sendMessageTo($receiver, $message){
      $mysqli = $this->db->getConnection();
      $receiverUsername = $receiver->getUsername();
      $sql = "INSERT INTO message(username_s, username_r, messageStr) VALUES ('$this->username', '$receiverUsername', '$message');";
      $mysqli->query($sql);
    }

  }
?>
