<?php
  require "phpMQTT-master/phpMQTT.php";
  include "connect.php";

  if (isset($_POST['change'])) {
    $status =  $_POST['change'];
    $id_device = $_POST['id'];
    $mqtt = new phpMQTT("soldier.cloudmqtt.com", 11600, "PHP MQTT Publisher");
    if ($mqtt->connect(true, NULL, "guapvdfg","k5WzGtSNWMQY")) {
      if($status == 1)
        $conn->query("UPDATE device SET status = 'checked' WHERE id = $id_device ");
      else
        $conn->query("UPDATE device SET status = NULL WHERE id = $id_device ");
      $mqtt->publish($id_device,1-$status, 0);
      $mqtt->close();
      echo '<script type="text/javascript">window.location.href ="control.php";</script>';
    }
  }
  if (isset($_POST['all_on'])) {
    // $obj_area = json_decode($_COOKIE["select"],true);
    $id_area = $_POST["all_on"];
    $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
    if ($res_device->num_rows > 0){
      while($row = $res_device->fetch_assoc()){
        $id_device = $row["id"];
        echo "<script>console.log(".$id_device.");</script>";
        $mqtt = new phpMQTT("soldier.cloudmqtt.com", 11600, "PHP MQTT Publisher");
        if ($mqtt->connect(true, NULL, "guapvdfg","k5WzGtSNWMQY")) {
          $conn->query("UPDATE device SET status = 'checked' WHERE id = $id_device ");
          $mqtt->publish($id_device,0, 0);
          $mqtt->close();
          echo '<script type="text/javascript">window.location.href ="control.php";</script>';
        }
      }
    }else echo '<script type="text/javascript">window.location.href ="control.php";</script>';
  }
  if (isset($_POST['all_off'])) {
    // $obj_area = json_decode($_COOKIE["select"],true);
    $id_area = $_POST["all_off"];
    $res_device = $conn->query("SELECT * FROM device WHERE areaid = $id_area");//Tat ca cac thiet bi co trong phong.
    if ($res_device->num_rows > 0){
      while($row = $res_device->fetch_assoc()){
        $id_device = $row["id"];
        echo "<script>console.log(".$id_device.");</script>";
        $mqtt = new phpMQTT("soldier.cloudmqtt.com", 11600, "PHP MQTT Publisher");
        if ($mqtt->connect(true, NULL, "guapvdfg","k5WzGtSNWMQY")) {
          $conn->query("UPDATE device SET status = NULL WHERE id = $id_device ");
          $mqtt->publish($id_device,1, 0);
          $mqtt->close();
          echo '<script type="text/javascript">window.location.href ="control.php";</script>';
        }
      }
    }else echo '<script type="text/javascript">window.location.href ="control.php";</script>';
  }
?>