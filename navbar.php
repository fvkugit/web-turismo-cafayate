<?php 
include_once("./utils/nodirecto.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
if(isset($_SESSION['id'])){
    $usuario = $usuarios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
}

$activePage = basename($_SERVER['PHP_SELF'], ".php");

?>
<div class="wrap">
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button id="primary-nav-button" type="button">Menu</button>
                    <a href="inicio.html">
                        <div class="logo">
                            <img src="img/logo2.png">
                        </div>
                    </a>
                    <nav id="primary-nav" class="dropdown cf">
                        <ul class="dropdown menu">
                            <li class="<?= ($activePage == 'index') ? 'active':''; ?>"><a href="index.php"><span>Inicio</span></a></li>
    
                            <li class="<?= ($activePage == 'comercios') ? 'active':''; ?>"><a href="comercios.php"><span>Comercios</span></a></li>

                            <li class="<?= ($activePage == 'novedades') ? 'active':''; ?>"><a href="novedades.php"><span>Novedades</span></a></li>

                            <li class="<?= ($activePage == 'turismo') ? 'active':''; ?>"><a href="turismo.php"><span>Turismo</span></a></li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cuenta
                                <ul class="dropdown-menu">
                                    <?php if(isset($_SESSION['logged'])) {	?>
                                        <li class="<?= ($activePage == 'miperfil') ? 'active':''; ?>"><a href="./miperfil.php">Mi perfil</a></li>
                                        <li class="<?= ($activePage == 'salir') ? 'active':''; ?>"><a href="./salir.php">Salir</a></li>
                                        <?php }else{	?>
                                        <li class="<?= ($activePage == 'ingresar') ? 'active':''; ?>"><a href="./ingresar.php">Ingresar</a></li>
                                        <li class="<?= ($activePage == 'registrarse') ? 'active':''; ?>"><a href="./registrarse.php">Registrarse</a></li>
                                    <?php }	?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>