<?php 
    $username = 'root';
    $password = '123';
    $server = 'localhost';
    $db = 'cafayate';
    $conexion = mysqli_connect($server,$username,$password,$db);
    if(!$conexion){die('Database connection error '.mysqli_connect_error());}
?> 