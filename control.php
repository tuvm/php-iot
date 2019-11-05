<!DOCTYPE html>
<html>
  <head>
    <title> Control </title>
    <link rel="Shortcut Icon" href="image/WSN.ico">
    <meta http-equiv="content-type" content="tex/html">
    <meta charset="UTF-8">
    <meta rel="stylesheet" href="font/Roboto.woff2">
    <meta rel="stylesheet" href="font/Lato.woff2">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default/style.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  </head>
  <body style="position:relative; margin: 0px;">
    <!-Taskbar-->
    <?php
      require "phpMQTT-master/phpMQTT.php";
      include "connect.php";
      include "taskbar.php";
      include "sidebar.php";
    ?>                  
    <script>
      openTab(3);
    </script>
    
    <!-Page-content-->
    <div id="page-content" style="float:left;color: #18699F;margin: 70px 0px 0px 200px;">
      <!-Graph-page-->      
      <div id="general-page" class="page" style="float:left ; width: 100%;" >
        <div id="general-title" class="page-title"> 
          <div> Control </div>  
          <input id="testbutton" type="checkbox" checked>
        </div>
        <?php
          function find_parent($id_parent,$conn){
            $res_parent = $conn->query("SELECT * FROM location WHERE id = $id_parent ");
            if ($res_parent->num_rows > 0){
              while($row = $res_parent->fetch_assoc()){
                $save_id = $row["parentid"];
                $save_area = $row["area"];
                return  $save_area ." / " .find_parent($save_id,$conn);
              }
            }
          }
          $obj = json_decode($_COOKIE["select"],true);
          if(isset($_POST['make']) && sizeof($obj) != 0){
            for( $i = 0; $i < sizeof($obj) ; $i++){
              $id_area = $obj[$i];
              $area = NULL;
              $des_area = NULL;
              $res_id = $conn->query("SELECT * FROM location WHERE parentid = $id_area ");//Xem id nay co phai la node la khong.
              if ($res_id->num_rows == 0){
                $ind = 0;
                $res_area = $conn->query("SELECT * FROM location WHERE id = $id_area ");
                if ($res_area->num_rows > 0){
                  while($row = $res_area->fetch_assoc()){
                    $des_area = $row["des"];
                    $area = find_parent($id_area,$conn);
                  }
                }
                echo '<div style="margin:10px 10px 10px 50px;border: 3px solid black; width:750px ;background-color: #FFFFFF ; float:left">
                      <div id="lighttext" class="sub-title"><span style="margin-left: 30px; margin-right: 20px; color:#0eed0e;"> '.$area .' </span></div>';
                
                $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
                if ($res_device->num_rows > 0){
                  while($row = $res_device->fetch_assoc()){
                    $device_id = $row["id"];
                    $device_name = $row["name"];
                    $device_code = $row["code"];
                    $device_status = $row["status"];
                    echo "
                        <label class='form-switch'>
                          <br><input id='device".$device_id."' type='checkbox' value='$device_id' $device_status> $device_name
                          <i></i>
                        </label>
                        <script>
                          $('#device".$device_id."').click(function(){
                            var stt = $(this).prop('checked');
                            if(stt) stt = 1;
                            else stt = 0;
                            $.post('make_control.php',{ change : stt, id : $device_id })
                            .done(function(data) {
                                // alert('Data Loaded: ' + data);
                            });

                          });   
                        </script>
                        ";
                    }
                    echo '
                        <center style="margin:10px">
                          <label">
                            <input  type="submit" id="allon'.$id_area.'"  name="all_on'.$id_area.'" class="square_btn" value="All On"> 
                            <i></i>
                          </label>
                          <script>
                            $("#allon'.$id_area.'").click(function(){
                               $.post("make_control.php",{ all_on : '.$id_area .' })
                              .done(function(data) {
                                  // alert(data);
                              });
                            });
                          </script>
                          <label">
                            <input  type="submit" id="alloff'.$id_area.'"  name="all_off'.$id_area.'" class="square_btn" value="All Off"> 
                            <i></i>
                          </label>
                          <script>
                            $("#alloff'.$id_area.'").click(function(){
                               $.post("make_control.php",{ all_off : '.$id_area.'  })
                              .done(function(data) {
                                  // alert(data);
                              });
                            });
                          </script>
                        </center>
                        <div id="checkboxlist"  style="" >';
                    echo ' <script>
                          $("#allon'.$id_area.'").click(function() {';
                          $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
                          if ($res_device->num_rows > 0){
                            while($row = $res_device->fetch_assoc()){
                              $device_id = $row["id"];
                              echo "$('#device".$device_id."').prop(\"checked\", true);";
                            }
                          }
                    echo "});
                        </script>";
                         echo " <script>
                          $('#alloff".$id_area."').click(function() {";
                          $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
                          if ($res_device->num_rows > 0){
                            while($row = $res_device->fetch_assoc()){
                              $device_id = $row["id"];
                              echo "$('#device".$device_id."').prop(\"checked\", false);";
                            }
                          }
                          echo "});
                          </script>
                        </div>";
                  
                }else echo '<center style="color:red;"><b>No device </b></center>';
                echo"</div>"; 
              }
            }
          }
          else{
            $res_all = $conn->query("SELECT * FROM location"); //truy van cac kieu du lieu da co.
            if ($res_all->num_rows > 0){
              while($row = $res_all->fetch_assoc()){
                $id_area = $row['id'];
                $area = NULL;
                $des_area = NULL;
                $res_id = $conn->query("SELECT * FROM location WHERE parentid = $id_area ");//Xem id nay co phai la node la khong.
                if ($res_id->num_rows == 0){
                  $ind = 0;

                  $res_area = $conn->query("SELECT * FROM location WHERE id = $id_area ");
                  if ($res_area->num_rows > 0){
                    while($row = $res_area->fetch_assoc()){
                      $des_area = $row["des"];
                      $area = find_parent($id_area,$conn);
                    }
                  }

                  echo'
                  <div style="margin:10px 10px 10px 50px;border: 3px solid black; width:750px ;background-color: #FFFFFF ; float:left">
                    <div id="lighttext" class="sub-title"><span style="margin-left: 30px; margin-right: 20px; color:#0eed0e;"> '.$area .' </span></div>';
                   
                  $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
                  if ($res_device->num_rows > 0){
                    while($row = $res_device->fetch_assoc()){

                      $device_id = $row["id"];
                      $device_name = $row["name"];
                      $device_code = $row["code"];
                      $device_status = $row["status"];
                      echo "
                        <label class='form-switch'>
                          <br><input id='device".$device_id."' type='checkbox' value='$device_id' $device_status> $device_name
                          <i></i>
                        </label>
                        <script>
                          $('#device".$device_id."').click(function(){
                            var stt = $(this).prop('checked');
                            if(stt) stt = 1;
                            else stt = 0;
                            $.post('make_control.php',{ change : stt, id : $device_id })
                            .done(function(data) {
                                // alert('Data Loaded: ' + data);
                            });

                          });   
                        </script>
                        ";
                    }
                    echo '
                        <center style="margin:10px">
                          <label">
                            <input  type="submit" id="allon'.$id_area.'"  name="all_on'.$id_area.'" class="square_btn" value="All On"> 
                            <i></i>
                          </label>
                          <script>
                            $("#allon'.$id_area.'").click(function(){
                               $.post("make_control.php",{ all_on : '.$id_area .' })
                              .done(function(data) {
                                  // alert(data);
                              });
                            });
                          </script>
                          <label">
                            <input  type="submit" id="alloff'.$id_area.'"  name="all_off'.$id_area.'" class="square_btn" value="All Off"> 
                            <i></i>
                          </label>
                          <script>
                            $("#alloff'.$id_area.'").click(function(){
                               $.post("make_control.php",{ all_off : '.$id_area.'  })
                              .done(function(data) {
                                  // alert(data);
                              });
                            });
                          </script>
                        </center>
                        <div id="checkboxlist"  style="" >';
                    echo ' <script>
                          $("#allon'.$id_area.'").click(function() {';
                          $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
                          if ($res_device->num_rows > 0){
                            while($row = $res_device->fetch_assoc()){
                              $device_id = $row["id"];
                              echo "$('#device".$device_id."').prop(\"checked\", true);";
                            }
                          }
                    echo "});
                        </script>";
                         echo " <script>
                          $('#alloff".$id_area."').click(function() {";
                          $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
                          if ($res_device->num_rows > 0){
                            while($row = $res_device->fetch_assoc()){
                              $device_id = $row["id"];
                              echo "$('#device".$device_id."').prop(\"checked\", false);";
                            }
                          }
                          echo "});
                          </script>
                        </div>";
                    
                  }else echo '<center style="color:red;"><b>No device </b></center>';
                  echo"</div>"; 
                }
              }
            }
          }
        ?>
      </div>
    </div>
  </body>
</html>
