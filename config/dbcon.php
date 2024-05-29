<?php

define('DB_SERVER',"localhost");
define('DB_USER',"root");
define('DB_PASS',"");
define('DB_NAME',"tugas_akhir_pos");

$conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

if($conn == false){
    dir('Error: Cannot connect');
}

?>