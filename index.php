<!DOCTYPE html>
<html>
  <head>
    <title> Monitor </title>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default/style.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js"></script>
    <script>
      function createCookie(name, value, days) {
          var expires;
          if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
          }
          else {
            expires = "";
          }
          document.cookie = name+ "=" + value + expires + "; path=/";
          //console.log(document.cookie);
      }
      createCookie("select_manage",'', "10");
      $(function () {
          $("#tree").jstree({
              "checkbox": {
                  "keep_selected_style": false,
                  "three_state":false,
                  "real_checkboxes":false
              },
              "plugins": ["types", "checkbox"],
              "core": {
                  "multiple": false
              },
              "types": {
                  "default": {
                      "icon": "fas fa-map-marker-alt"
                  }
              }
          });
          $("#tree").bind("changed.jstree",
          function (e, data) {
            var output = {};
            for(i=0 ;i<data.selected.length ;i++){
               output[i] = data.selected[i];
            }
            var kq = JSON.stringify(output);
            console.log(output);
            console.log(kq);
            createCookie("select_manage", kq , "10");
          });
      });
    </script>
  </head>
  <div id="container">
    <body  style="position:relative; margin: 0px;">
      <?php
        include "connect.php";
        include "taskbar.php";
      ?>
      <script >
        openTab(5);
      </script>
      <div id="sidebar" style="position:fixed;width: 200px;height:100%; background-color: #1E282C; padding: 0px; margin: 70px 0px; color: #ECF0F5; float:left;">
      </div>
      <div id="page-content" style="float:left;height:100%;color: #18699F;margin: 70px 0px 0px 200px;">
        <div id="general-page" class="page">
        </div>
      <div>
        <script type="text/javascript">
          function printData(){
              setInterval(function(){
              var test = [<?php $Mn=$conn->query("SELECT * FROM sensordata WHERE id = (SELECT MAX(id) FROM sensordata)");
              if ($Mn->num_rows > 0){
                while($row = $Mn->fetch_assoc()){
                  echo $row['id'];
                }
              }
              ?>];
              console.log(test);
              },1000);
            }
            printData();
        </script>
      </div>
    </body>
  </div>
</html>
