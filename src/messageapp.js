function message(username, chatusername){
  var str = "#messageBox";
  var chatBox = document.querySelector(str);
  $.ajax({
    data: {"user":username, "chat":chatusername},
    url: 'messageapp.php',
    method: 'POST', // or GET
    success: function(data){
      if(chatBox.textContent!==data){
        chatBox.textContent = data;
          chatBox.scrollTop = 999999;
      }

    }
  });

}

function setMessageBox(username, chatusername){
  setInterval(message, 1000, username, chatusername);
}

function sendMessage(sender, receiver){
  var str = "#messageArea";
  var messageArea = document.querySelector(str);
  str = "#messageBox";
  var chatBox = document.querySelector(str);
  $.ajax({
    data: {"sender":sender, "receiver":receiver, "message":messageArea.value},
    url: 'messageapp.php',
    method: 'POST', // or GET
    success: function(){
      message(sender, receiver);
    }
  });
    messageArea.value = "";
    chatBox.scrollTop = 999999;
}
