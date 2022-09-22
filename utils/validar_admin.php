<?php 
include_once("./utils/nodirecto.php");
include_once("./utils/sessions.php");
if (!$_SESSION['rol'] || $_SESSION['rol'] != "Admin") {
    header("Location: ./index.php");
}
?>