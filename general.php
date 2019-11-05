<!DOCTYPE html>
<html>
  <head>
    <title> Detail </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/main/style.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default/style.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js"></script>
    <script>
      function drawDonut(c,posX,posY,value,oldValue,minValue,maxValue,rgb){
        var range = maxValue - minValue,
          ratio = 100/range,
          fps = 1000 / 200,
          procent = 0,
          oneProcent = 360 / range,
          oneColor = 150 / range,
          result = oneProcent * (value - minValue);
          c.font = "22px Lato";
          var deegres = oldValue * oneProcent;
          var acrInterval = setInterval (function() {
            if (deegres > result){
              factor = -1; 
            }else{
              factor = 1;
            }
            deegres += factor;
            c.clearRect( 0, 0, posX*2, posY*2 );
            procent = deegres / oneProcent + minValue;
            if(procent > maxValue){
              procent = maxValue;
            }else if(procent < minValue){
              procent = minValue;
            }
            index = 1;
            c.beginPath();
            c.arc( posX, posY, 40, (Math.PI/180) * 270, (Math.PI/180) * (270 + 360) );
            c.strokeStyle = '#b1b1b1';
            c.lineWidth = '18';
            c.stroke();
            c.beginPath();
            c.strokeStyle = rgb;
            c.lineWidth = '18';
            c.arc( posX, posY, 40, (Math.PI/180) * 270, (Math.PI/180) * (270 + deegres) );
            c.stroke();
            c.fillStyle = rgb;
            c.textAlign = "center";
            c.textBaseline = "middle";
            c.fillText(procent.toFixed(index),posX,posY);
            if( deegres * factor >= result * factor ) clearInterval(acrInterval);
        }, fps);
      }
     
    </script>
  </head>
  <body  style="position:relative; margin: 0px;">
    <?php
      include "connect.php";
      include "taskbar.php";
      include "sidebar.php";
    ?>
    <script>
      openTab(2);
    </script>
    <div id="page-content" style="float:left; width: auto ; height:auto;color: #18699F;margin: 70px 0px 0px 200px;">
      <div id="general-page" class="page">
        <div id="general-title" class="page-title"> 
          <div> Detail </div> 
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
              $cur_id = "0";
              $min_value = 0;
              $min_time = "0";
              $max_value = 0;
              $max_time = "0";
              $before = 0;
              $avg_value=0;
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

                echo "<div style=\"margin:10px 10px 10px 10px;border: 3px solid black; width:99% ;background-color: #FFFFFF ; float:left\">
                        <div class=\"sub-title\">
                        <span style=\"float:left ;margin-left: 15px; color:#FFF8DC;\">Location : $area </span>
                        <!--<div style=\"float:left ; margin-left: 50px; font-size: 20px ;color:#FFF8DC;\">Mô tả :$des_area</div>-->
                      </div>";
                $res_type = $conn->query("SELECT * FROM sensor"); //truy van cac kieu du lieu da co.
                if ($res_type->num_rows > 0){
                  while($row = $res_type->fetch_assoc()){
                    $id_sensor = $row["id"];
                    $cur_id = $row["code"];
                    $sensor = $row["type"];
                    $min_range = explode(",",$row["arange"])[0];
                    $range_1 = explode(",",$row["arange"])[1];
                    $range_2 = explode(",",$row["arange"])[2];
                    $max_range = explode(",",$row["arange"])[3];
                    $status = NULL;
                    $icon = $row['icon'];
                    $don_vi = $row["ext"];
                    $color = $row["des"];
                    $res_cur_id = $conn->query("SELECT id FROM router WHERE areaid = $id_area and sensorid = $id_sensor");
                    if ($res_cur_id->num_rows > 0){
                      $ind = $ind + 2;
                      while($row = $res_cur_id->fetch_assoc()){
                        $cur_id = $row["id"];

                        $Avg = $conn->query("SELECT AVG(value) AS av FROM sensordata WHERE sensor = $cur_id");
                        if ($Avg->num_rows > 0){
                          while($row = $Avg->fetch_assoc()){
                            $avg_value=$row["av"];
                          }
                        }

                        $Mx = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MAX(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                        if ($Mx->num_rows > 0){
                          while($row = $Mx->fetch_assoc()){
                            $max_value=$row["value"];
                            $max_time=(string)$row["time"];
                          }
                        }
                        $Mn = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MIN(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                        if ($Mn->num_rows > 0){
                          while($row = $Mn->fetch_assoc()){
                            $min_value=$row["value"];
                            $min_time=(string)$row["time"];
                          }
                        }

                        $cur_value = $conn->query("SELECT * FROM sensordata WHERE id = ( SELECT MAX(id) FROM sensordata WHERE sensor = $cur_id )");
                        if ($cur_value->num_rows > 0){
                          while($row = $cur_value->fetch_assoc()){
                            if($row['value']>=$min_range&&$row['value'] < $range_1){
                              $status = "LOW";
                              $colorstt = "#DD0000";
                            }
                            if($row['value']>=$range_1&&$row['value'] < $range_2){
                              $status = "MEDIUM";
                              $colorstt = "#00CC00";
                            }
                            if($row['value']>=$range_2&&$row['value'] <= $max_range){
                              $status = "HIGHT";
                              $colorstt = "#DD0000";
                            }
                            //echo $min_range ." " .$max_range ."<br>";
                            echo "<script>
                              function printData(){
                                    var befor$cur_id = 0;
                                    setInterval(function(){
                                    a$cur_id = document.getElementById(\"donut-$cur_id\");
                                    drawDonut(a$cur_id.getContext(\"2d\"),60,90,".$row["value"] .",befor$cur_id,0,$max_range,\"$colorstt\");
                                    document.getElementById('max$cur_id').innerHTML = $max_value;
                                    document.getElementById('min$cur_id').innerHTML = $min_value;
                                    document.getElementById('avg$cur_id').innerHTML = $avg_value;
                                    befor$cur_id = ".$row["value"] .";
                                    //document.getElementById('time-max$cur_id').innerHTML = $max_time;
                                    //document.getElementById('time-min$cur_id').innerHTML = $min_time;
                                  },1000);
                                }
                                printData();
                              </script>";
                              echo "
                              <div style=\"margin:10px 10px 10px 10px;border: 1px solid gray; width: 395px ; height : 200px ;float:left ;background-color: #ECF0F5;\">
                                <div class=\"sub-title\">
                                  <span style=\"margin-left: 15px; font-size: 20px; color:".$color.";\"><span class='$icon'></span> $sensor</span>
                                </div>
                                <div style=\"height:120px;width:120px;float:left\">
                                  <canvas id=\"donut-$cur_id\"width=\"250\" height=\"250\">
                                    </canvas>
                                </div>
                                <div style=\"float:left;\">
                                  <table title=\"$cur_id Table\" style=\" margin:20px 0px 10px 0px ; border-collapse: collapse;\">
                                    <tr>
                                      <td style=\"border: none;font-size: 15px;\"> Avg </td>
                                      <td style=\"border: none;font-size: 15px;\" id=\"avg$cur_id\"> </td>
                                
                                    </tr>
                                    <tr>
                                      <td style=\"border: none;font-size: 15px;\"> Max </td>
                                      <td style=\"border: none;font-size: 15px;\" id=\"max$cur_id\"> NaNa </td>
                                      <td style=\"border: none;font-size: 15px;\" id=\"time-max$cur_id\"> $max_time </td>
                                    </tr>
                                    <tr>
                                      <td style=\"border: none;font-size: 15px;\"> Min </td>
                                      <td style=\"border: none;font-size: 15px;\" id=\"min$cur_id\"> NaNa </td>
                                      <td style=\"border: none;font-size: 15px;\" id=\"time-min$cur_id\"> $min_time </td>
                                    </tr>
                                    <tr>
                                      <td style=\"border: none;font-size: 15px;\"> Range </td>
                                      <td style=\"border: none;font-size: 15px;\"></td>
                                      <td  solspan=\"2\" style=\"border: none;font-size: 15px;\"> $min_value - $max_value ($don_vi)</td>
                                    </tr>
                                    <tr>
                                      <td style=\"border: none;font-size: 15px;\"> Status </td>
                                      <td style=\"border: none;font-size: 15px;\"></td>
                                      <td  solspan=\"2\" style=\"border: none;font-size: 15px;color:$colorstt\";\"> $status </td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                              " ;
                            }
                          }
                        }
                      }
                    }
                  }
                  echo "</div>";
                }
              }
            }
            else{
              $res_all = $conn->query("SELECT * FROM location"); //truy van cac kieu du lieu da co.
              if ($res_all->num_rows > 0){
                while($row = $res_all->fetch_assoc()){
                  $cur_id = "0";
                  $min_value = 0;
                  $min_time = "0";
                  $max_value = 0;
                  $max_time = "0";
                  $before = 0;
                  $avg_value=0;
                  $id_area = $row["id"];
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

                    echo "<div style=\"margin:10px 10px 10px 10px;border: 3px solid black; width:99% ;background-color: #FFFFFF ; float:left\">
                            <div class=\"sub-title\">
                            <span style=\"float:left ;margin-left: 15px; color:#FFF8DC;\">Location : $area </span>
                            <!--<div style=\"float:left ; margin-left: 50px; font-size: 20px ;color:#FFF8DC;\">Mô tả :$des_area</div>-->
                          </div>";

                    $res_type = $conn->query("SELECT * FROM sensor"); //truy van cac kieu du lieu da co.
                    if ($res_type->num_rows > 0){
                      while($row = $res_type->fetch_assoc()){
                        $id_sensor = $row["id"];
                        $cur_id = $row["code"];
                        $sensor = $row["type"];
                        $min_range = explode(",",$row["arange"])[0];
                        $range_1 = explode(",",$row["arange"])[1];
                        $range_2 = explode(",",$row["arange"])[2];
                        $max_range = explode(",",$row["arange"])[3];
                        $status = NULL;
                        $colorstt = NULL;
                        $icon = $row['icon'];
                        $don_vi = $row["ext"];
                        $color = $row["des"];
                        $res_cur_id = $conn->query("SELECT id FROM router WHERE areaid = $id_area and sensorid = $id_sensor");
                        if ($res_cur_id->num_rows > 0){
                          $ind = $ind + 2;
                          while($row = $res_cur_id->fetch_assoc()){
                            $cur_id = $row["id"];

                            $Avg = $conn->query("SELECT AVG(value) AS av FROM sensordata WHERE sensor = $cur_id");
                            if ($Avg->num_rows > 0){
                              while($row = $Avg->fetch_assoc()){
                                $avg_value=$row["av"];
                              }
                            }

                            $Mx = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MAX(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                            if ($Mx->num_rows > 0){
                              while($row = $Mx->fetch_assoc()){
                                $max_value=$row["value"];
                                $max_time=(string)$row["time"];
                              }
                            }
                            $Mn = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MIN(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                            if ($Mn->num_rows > 0){
                              while($row = $Mn->fetch_assoc()){
                                $min_value=$row["value"];
                                $min_time=(string)$row["time"];
                              }
                            }
                            $cur_value = $conn->query("SELECT * FROM sensordata WHERE id = ( SELECT MAX(id) FROM sensordata WHERE sensor = $cur_id )");
                            
                            if ($cur_value->num_rows > 0){
                              while($row = $cur_value->fetch_assoc()){
                                if($row['value']>=$min_range&&$row['value'] < $range_1){
                              $status = "LOW";
                              $colorstt = "#DD0000";
                            }
                            if($row['value']>=$range_1&&$row['value'] < $range_2){
                              $status = "MEDIUM";
                              $colorstt = "#00CC00";
                            }
                            if($row['value']>=$range_2&&$row['value'] <= $max_range){
                              $status = "HIGHT";
                              $colorstt = "#DD0000";
                            }
                                // echo $min_range ." " .$max_range ."<br>";
                                echo "<script>
                                  function printData(){
                                      var befor$cur_id = 0;
                                      setInterval(function(){
                                        a$cur_id = document.getElementById(\"donut-$cur_id\");
                                        drawDonut(a$cur_id.getContext(\"2d\"),60,90,".$row["value"] .",befor$cur_id,0,$max_range,\"$colorstt\");
                                        document.getElementById('max$cur_id').innerHTML = $max_value;
                                        document.getElementById('min$cur_id').innerHTML = $min_value;
                                        document.getElementById('avg$cur_id').innerHTML = $avg_value;
                                        befor$cur_id = ".$row["value"] .";
                                        //document.getElementById('time-max$cur_id').innerHTML = $max_time;
                                        //document.getElementById('time-min$cur_id').innerHTML = $min_time;
                                      },1000);
                                    }
                                    printData();
                                  </script>";
                                  echo "
                                  <div style=\"margin:10px 10px 10px 10px;border: 1px solid gray; width: 395px ; height : 200px ;float:left ;background-color: #ECF0F5;\">
                                    <div class=\"sub-title\">
                                      <span style=\"margin-left: 15px; font-size: 20px; color:".$color.";\"><span class='$icon'></span> $sensor</span>
                                    </div>
                                    <div style=\"height:120px;width:120px;float:left\">
                                      <canvas id=\"donut-$cur_id\"width=\"250\" height=\"250\">
                                        </canvas>
                                    </div>
                                    <div style=\"float:left;\">
                                      <table title=\"$cur_id Table\" style=\" margin:20px 0px 10px 0px ; border-collapse: collapse;\">
                                        <tr>
                                          <td style=\"border: none;font-size: 15px;\"> Avg </td>
                                          <td style=\"border: none;font-size: 15px;\" id=\"avg$cur_id\"> $avg_value</td>
                                    
                                        </tr>
                                        <tr>
                                          <td style=\"border: none;font-size: 15px;\"> Max </td>
                                          <td style=\"border: none;font-size: 15px;\" id=\"max$cur_id\"> $max_value </td>
                                          <td style=\"border: none;font-size: 15px;\" id=\"time-max$cur_id\"> $max_time </td>
                                        </tr>
                                        <tr>
                                          <td style=\"border: none;font-size: 15px;\"> Min </td>
                                          <td style=\"border: none;font-size: 15px;\" id=\"min$cur_id\"> $min_value </td>
                                          <td style=\"border: none;font-size: 15px;\" id=\"time-min$cur_id\"> $min_time </td>
                                        </tr>
                                        <tr>
                                          <td style=\"border: none;font-size: 15px;\"> Range </td>
                                          <td style=\"border: none;font-size: 15px;\"></td>
                                          <td  solspan=\"2\" style=\"border: none;font-size: 15px;\"> $min_value - $max_value ($don_vi)</td>
                                        </tr>
                                        <tr>
                                          <td style=\"border: none;font-size: 15px;\"> Status </td>
                                          <td style=\"border: none;font-size: 15px;\"></td>
                                          <td  solspan=\"2\" style=\"border: none;font-size: 15px;color:$colorstt;\"> $status </td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
                                  " ;
                                }
                              }
                            }
                          }
                        }
                      }
                      echo "</div>";
                    }
                }
              }
            }
          ?>
      </div>
    </div> 
  </body>

</html>
