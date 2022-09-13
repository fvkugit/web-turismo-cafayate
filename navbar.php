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
                            <li class='active'><a href="index.php">Inicio</a></li>
    
                            <li><a href="comercios.html">Comercios</a></li>

                            <li><a href="novedades.html">Novedades</a></li>

                            <li><a href="turismo.html">Turismo</a></li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cuenta
                                <ul class="dropdown-menu">
                                    <?php if(isset($_SESSION['logged'])) {	?>
                                        <li><a href="./miperfil.php">Mi perfil</a></li>
                                        <li><a href="./salir.php">Salir</a></li>
                                        <?php }else{	?>
                                        <li><a href="./ingresar.php">Ingresar</a></li>
                                        <li><a href="./registrarse.php">Registrarse</a></li>
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