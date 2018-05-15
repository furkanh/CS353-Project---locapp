function likeComment(username, placeID, commentID){
  var str = "#likeCommentID-";
  str = str.concat(placeID, "-", commentID);
  var button = document.querySelector(str);
  str = "#numOfLikesID-";
  str = str.concat(placeID, "-", commentID);
  var numOfLikesItem = document.querySelector(str);
  if(button.textContent==="Like"){
    $.ajax({
      data: {"commentLikeUsername":username, "commentLikePlaceID" : placeID, "commentLikeCommentID" : commentID},
      url: 'like.php',
      method: 'POST', // or GET
    });
    button.classList.remove("btn-outline-success");
    button.classList.add("btn-success");
    button.textContent = "Dislike";
    var num = parseInt(numOfLikesItem.textContent);
    numOfLikesItem.textContent = num + 1;
    numOfLikesItem.textContent = numOfLikesItem.textContent.concat(" Likes");
  }
  else {
    $.ajax({
      data: {"commentDislikeUsername":username, "commentDislikePlaceID" : placeID, "commentDislikeCommentID" : commentID},
      url: 'like.php',
      method: 'POST', // or GET
    });
    button.classList.remove("btn-success");
    button.classList.add("btn-outline-success");
    button.textContent = "Like";
    var num = parseInt(numOfLikesItem.textContent);
    numOfLikesItem.textContent = num - 1;
    numOfLikesItem.textContent = numOfLikesItem.textContent.concat(" Likes");
  }
}

function likeCheckIn(likerUsername, username, placeID, datetime, time){
  var str = "#likeCheckInID-";
  str = str.concat(username, "-", placeID, "-", time);
  var button = document.querySelector(str);
  str = "#numOfLikesID-";
  str = str.concat(username, "-", placeID, "-", time);
  var numOfLikesItem = document.querySelector(str);
  if(button.textContent==="Like"){
    $.ajax({
      data: {"likerUsername":likerUsername, "likeCheckInUsername" : username, "likeCheckInPlaceID" : placeID, "likeCheckInDatetime" : datetime},
      url: 'like.php',
      method: 'POST', // or GET
    });
    button.classList.remove("btn-outline-success");
    button.classList.add("btn-success");
    button.textContent = "Dislike";
    var num = parseInt(numOfLikesItem.textContent);
    numOfLikesItem.textContent = num + 1;
    numOfLikesItem.textContent = numOfLikesItem.textContent.concat(" Likes");
  }
  else {
    $.ajax({
      data: {"likerUsername":likerUsername, "dislikeCheckInUsername" : username, "dislikeCheckInPlaceID" : placeID, "dislikeCheckInDatetime" : datetime},
      url: 'like.php',
      method: 'POST', // or GET
    });
    button.classList.remove("btn-success");
    button.classList.add("btn-outline-success");
    button.textContent = "Like";
    var num = parseInt(numOfLikesItem.textContent);
    numOfLikesItem.textContent = num - 1;
    numOfLikesItem.textContent = numOfLikesItem.textContent.concat(" Likes");

  }
}
