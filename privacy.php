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
    
  </head>
  <body  style="position:relative; margin: 0px;">
    <?php
      include "connect.php";
      include "taskbar.php";
      include "sidebar.php";
    ?>
    <script>
      openTab(1);
    </script>
    <div id="page-content" style="float:left;height:1000px;color: #18699F;margin: 70px 0px 0px 200px;">
      <b> Just for test ! :)
      </b>
    </div>
  </body>
</html>
