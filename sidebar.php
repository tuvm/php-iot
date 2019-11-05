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
// createCookie("select",'', "10");
$(function () {
    $("#tree").jstree({
        "checkbox": {
            "keep_selected_style": false
        },
        "plugins": [ "types", "checkbox"],
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
      //console.log(output);
      console.log(kq);
      createCookie("select", kq , "/");
    });
});
</script>

<div id="sidebar" style="position:fixed;width: 200px;height:100%; background-color: #1E282C; padding: 0px; margin: 70px 0px; color: #ECF0F5; float:left;z-index: 10;">
  <div id="menu_text" style="height: 60px; text-align: center; vertical-align: middle; line-height: 60px; border-bottom: 1px solid #ECF0F5">
    <p style="font-size: 20px;margin: 0;px border-bottom: 1px solid #ECF0F5; border-top: 1px solid #ECF0F5"><strong> Location </strong></p>
  </div>
  <div id="tree" style="width: auto; background-color: #ECF0F5 ;color: black; padding: 0px; margin: 5px 0px 5px 5px">
    <?php
      function trytry($id_parent,$conn){
        $res_id_t = $conn->query("SELECT * FROM location WHERE parentid = $id_parent ");
        if ($res_id_t->num_rows > 0){
          echo "
          <ul>";
          while($row = $res_id_t->fetch_assoc()){
            $save_id = $row["id"];
            $save_area = $row["area"];
            $icon = $row["ext"];
            echo "
              <li id=\"$save_id\" data-jstree = '{\"icon\": \"" .$icon ."\"}' >$save_area";
            trytry($save_id,$conn);
            echo "
              </li>";
          }
          echo "
          </ul>";
        }
      }
      $res_id = $conn->query("SELECT * FROM location where parentid IS NULL ");
      if ($res_id->num_rows > 0){ 
        echo "
        <ul>";
        while($row = $res_id->fetch_assoc()){
          $save_id = $row["id"];
          $save_area = $row["area"];
          $icon = $row["ext"];
          echo "
            <li id=\"$save_id\" data-jstree = '{\"icon\": \"" .$icon ."\"}' >$save_area";
          trytry($save_id,$conn);
          echo"
            </li>";
        }
        echo "
        </ul>";
      }
    ?>
  </div>
  <form action="#" method="post">
    <input type="submit" style = " margin-left: 20px " name="make" value="Check"></form>
  </form>
 
</div>