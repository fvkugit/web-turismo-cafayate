<?php
include_once("./utils/nodirecto.php");
session_start();
session_destroy();
$message = "Su sesión se ha cerrado correctamente.";
require("result.php");
?>