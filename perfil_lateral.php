<?php 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<div class="profile-usermenu">
    <ul class="nav">
        <li class="<?= ($activePage == 'miperfil') ? 'active':''; ?>">
            <a href="./miperfil.php">
                <i class="glyphicon glyphicon-home"></i>
                Mis datos </a>
        </li>
        <li class="<?= ($activePage == 'micomercio') ? 'active':''; ?>">
            <a href="./micomercio.php">
                <i class="glyphicon glyphicon-shopping-cart"></i>
                Mi comercio </a>
        </li>
        <?php if ($usuario["rol"] === "Admin") { ?>
            <li class="category">
                <i class="	glyphicon glyphicon-wrench"></i>
                Admin
            </li>
            <li class="<?= ($activePage == 'panel_inicio') ? 'active':''; ?>">
                <a href="./panel_inicio.php">
                    <i class="glyphicon glyphicon-home"></i>
                    Inicio </a>
            </li>
            <li class="<?= ($activePage == 'panel_turismo') ? 'active':''; ?>">
                <a href="./panel_turismo.php">
                    <i class="glyphicon glyphicon-camera"></i>
                    Turismo </a>
            </li>
            <li class="<?= ($activePage == 'panel_usuarios') ? 'active':''; ?>">
                <a href="./panel_usuarios.php">
                    <i class="glyphicon glyphicon-user"></i>
                    Usuarios </a>
            </li>
            <li class="<?= ($activePage == 'solicitudes') ? 'active':''; ?>" class="active">
                <a href="./solicitudes.php">
                    <i class="glyphicon glyphicon-book"></i>
                    Solicitudes </a>
            </li>
            <li class="<?= ($activePage == 'panel_comercios') ? 'active':''; ?>">
                <a href="./panel_comercios.php">
                    <i class="glyphicon glyphicon-certificate"></i>
                    Comercios </a>
            </li>
        <?php } ?>
    </ul>
</div>