<?php 
include_once("./utils/sessions.php");
if (!$_SESSION['logged']) {
    header("Location: ./ingresar.php");
}

?>