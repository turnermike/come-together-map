<?PHP 
session_start();
echo "testVar: " . $_SESSION["testVar"];
echo "<br />session id: " . session_id();
?>
