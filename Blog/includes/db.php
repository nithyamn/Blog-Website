<?php
//jab tak hosting server ek hai tab tak this will be localhost: jab different hots hoga the yaha ip address aega of db host
define("SERVER","localhost");
define("USER","root");
define("PASSWORD","");
define("DB","cms");

$conn=mysqli_connect(SERVER,USER,PASSWORD,DB);

if(!$conn)
	echo "Connection diesd due to ".mysqli_connect_error();
?>