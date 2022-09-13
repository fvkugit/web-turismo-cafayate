<?php

require_once("./db/model.php");
$db_base = new DBConexion();
$usuarios = new Usuarios("usuarios", $db_base);
$solicitudes = new Solicitudes("solicitudes_comerciante", $db_base);

?>
