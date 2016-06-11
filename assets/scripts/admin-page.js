// Hides log table except log page
document.addEventListener("DOMContentLoaded", function(event) {
  stampTable();
  var anchors = document.querySelectorAll('.nav-tab-wrapper a');
  for (var i = 0; i < anchors.length; i++) {
    var elem = anchors[i];   
    elem.onclick = function(){
      stampTable();
    };
  }
  function stampTable() {
    if (document.getElementById('logs-tab').classList.contains('nav-tab-active')) {
      document.getElementById('logTable').style.display = 'inline';
    } else {
      document.getElementById('logTable').style.display = 'none';
    }
  }
});
