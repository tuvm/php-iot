<?php

    include "connect.php";
    $min_value = 0;
    $min_time = "0";
    $max_value = 0;
    $max_time = "0";
    $avg_value=0;
    if(isset($_POST["request"])){

        $obj = json_decode($_COOKIE["select"],true);
        if(sizeof($obj) != 0){
            for( $i = 0; $i < sizeof($obj) ; $i++){

                $cur_id = "0";
                $min_value = 0;
                $min_time = "0";
                $max_value = 0;
                $max_time = "0";
                $before = 0;
                $avg_value=0;
                $id_area = $obj[$i];
                $res_id = $conn->query("select * FROM location WHERE parentid = $id_area ");//Xem id nay co phai la node la khong.
                if ($res_id->num_rows == 0){
                    $ind = 0;
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
                            $time ="time";
                            
                            $res_cur_id = $conn->query("SELECT id FROM router WHERE areaid = $id_area AND sensorid = $id_sensor");
                            if ($res_cur_id->num_rows > 0){

                                while($row = $res_cur_id->fetch_assoc()){
                                    $cur_id = $row["id"];
                                    $data[$cur_id]['mx_r']=$max_range;
                                    
                                    $Avg = $conn->query("SELECT AVG(value) AS av FROM sensordata WHERE sensor = $cur_id");
                                    if ($Avg->num_rows > 0){
                                        while($row = $Avg->fetch_assoc()){
                                            $data[$cur_id]['av']=$row["av"];
                                        }
                                    }

                                    $Mx = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MAX(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                                    if ($Mx->num_rows > 0){
                                        while($row = $Mx->fetch_assoc()){
                                            $data[$cur_id]['mx']=$row["value"];
                                            $data[$cur_id]['mx_t']=(string)$row["time"];
                                        }
                                    }
                                    $Mn = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MIN(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                                    if ($Mn->num_rows > 0){
                                        while($row = $Mn->fetch_assoc()){
                                            $data[$cur_id]['mn']=$row["value"];
                                            $data[$cur_id]['mn_t']=(string)$row["time"];
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
                                            $data[$cur_id]['stt']=$status;
                                            $data[$cur_id]['stt_cl']=$colorstt;
                                            $data[$cur_id]['cr_vl']=$row["value"];
                                            $old_value = $row["value"];
                                        }
                                    }
                                    
                                }
                            }
                        }
                        
                    }
                }
            }
            echo json_encode($data);
            mysqli_close($conn);
        }else{
            $res_all = $conn->query("SELECT * FROM location"); //truy van cac kieu du lieu da co.
            if ($res_all->num_rows > 0){
                while($row = $res_all->fetch_assoc()){
                    $id_area = $row["id"];
                    $cur_id = "0";
                    $min_value = 0;
                    $min_time = "0";
                    $max_value = 0;
                    $max_time = "0";
                    $before = 0;
                    $avg_value=0;
                    $res_id = $conn->query("select * FROM location WHERE parentid = $id_area ");//Xem id nay co phai la node la khong.
                    if ($res_id->num_rows == 0){
                        $ind = 0;
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
                                $time ="time";
                                
                                $res_cur_id = $conn->query("SELECT id FROM router WHERE areaid = $id_area AND sensorid = $id_sensor");
                                if ($res_cur_id->num_rows > 0){

                                    while($row = $res_cur_id->fetch_assoc()){
                                        $cur_id = $row["id"];
                                        $data[$cur_id]['mx_r']=$max_range;
                                        
                                        $Avg = $conn->query("SELECT AVG(value) AS av FROM sensordata WHERE sensor = $cur_id");
                                        if ($Avg->num_rows > 0){
                                            while($row = $Avg->fetch_assoc()){
                                                $data[$cur_id]['av']=$row["av"];
                                            }
                                        }

                                        $Mx = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MAX(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                                        if ($Mx->num_rows > 0){
                                            while($row = $Mx->fetch_assoc()){
                                                $data[$cur_id]['mx']=$row["value"];
                                                $data[$cur_id]['mx_t']=(string)$row["time"];
                                            }
                                        }
                                        $Mn = $conn->query("SELECT * FROM sensordata WHERE value = (SELECT MIN(value) FROM sensordata WHERE sensor = $cur_id) AND sensor = $cur_id");
                                        if ($Mn->num_rows > 0){
                                            while($row = $Mn->fetch_assoc()){
                                                $data[$cur_id]['mn']=$row["value"];
                                                $data[$cur_id]['mn_t']=(string)$row["time"];
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
                                                $data[$cur_id]['stt']=$status;
                                                $data[$cur_id]['stt_cl']=$colorstt;
                                                $data[$cur_id]['cr_vl']=$row["value"];
                                                $old_value = $row["value"];
                                            }
                                        }
                                        
                                    }
                                }
                            }
                        }
                    }
                }
                echo json_encode($data);
                mysqli_close($conn);
            }
            
        }
    }
?>
