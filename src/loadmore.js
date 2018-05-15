window.getCookie = function(name) {
  match = document.cookie.match(new RegExp(name + '=([^;]+)'));
  if (match) return match[1];
}

function savePosition(){
  $.ajax({
    data: {"pageLoc":document.documentElement.scrollTop},
    url: 'pageloc.php',
    method: 'POST', // or GET
  });
}

var c = getCookie("pageLoc");
document.documentElement.scrollTop = parseInt(c);
