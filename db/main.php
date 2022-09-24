<?php
include_once("./utils/nodirecto.php");
require_once("./db/model.php");
$db_base = new DBConexion();
$usuarios = new Usuarios("usuarios", $db_base);
$solicitudes = new Solicitudes("solicitudes_comerciante", $db_base);
$novedades = new Novedades("novedades", $db_base);
$dpublica = new DPublica("datos_publicos", $db_base);
$comercios = new Comercios("comercios", $db_base);
$comercios_imagenes = new Comercios_Imagenes("comercios_imagenes", $db_base);
$novedades_categorias = new DBModelo("novedades_categorias", $db_base);


?>
