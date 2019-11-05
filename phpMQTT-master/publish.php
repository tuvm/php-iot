<?php

require "phpMQTT.php";
?>

<html>
<body>

	<form action="publish.php" method="POST">
	Topic: <input type="text" name=topic><br>
	Message: <input type="text" name=message><br>
	<input type="submit" name="submit" value="Submit">
	</form>

</body>
</html>

<?php 
        
    if (isset($_POST['submit'])) {
        $mqtt = new phpMQTT("localhost", 1883, "PHP MQTT Publisher");
        if ($mqtt->connect()) {
            echo "Published TOPIC:" . " " . $_POST['topic'] . "<br>";
            echo "Published MESSAGE:" . " " . $_POST['message'] . "<br>";
            $mqtt->publish($_POST['topic'], $_POST['message'], 0);
            $mqtt->close();
        }
    }
?>