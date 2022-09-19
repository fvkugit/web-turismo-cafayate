<?php
include_once("./utils/sessions.php");
include_once("./db/main.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Proyecto Cafayate Comercios</title>

    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="css/fontAwesome.css" />
    <link rel="stylesheet" href="css/hero-slider.css" />
    <link rel="stylesheet" href="css/owl-carousel.css" />
    <link rel="stylesheet" href="css/style.css" />

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet" />

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <?php
    if (($_SERVER['REQUEST_METHOD'] === "POST") and (isset($_POST['login']))) {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $res = $usuarios->login(["correo"=>"'$email'", "password"=>"$pass"]);
        unset($_POST['login']);
        if ($res[0]) {
            $userdata = $res[1];
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $userdata['correo'];
            $_SESSION['id'] = $userdata['id_usuario'];
            $_SESSION['rol'] = $userdata['rol'];
            $message = "Iniciaste sesión correctamente.";
            require("result.php");
        } else {
            $error = "Los datos de inicio no son correctos.";
            require("ingresar.php");
        }
    } else {
    ?>
        <?php include_once 'navbar.php'; ?>

        <section class="banner banner-secondary" id="top" style="background-image: url(img/banner-image-1-1920x3001.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="banner-caption">
                            <div class="line-dec"></div>
                            <h2>Cuenta</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main>
            <div class="container">
                <div class="row">
                    <form method="POST" class="form-signin mg-btm mx-auto">
                        <h3 class="heading-desc">
                            Bienvenido nuevamente
                        </h3>
                        <?php if (isset($error)) { ?>
                            <h3 class="heading-desc text-red">
                                <?php echo ($error) ?>
                            </h3>
                        <?php } ?>

                        <div class="main">
                            <label for="email">Ingresa tu correo electronico</label>
                            <input type="text" class="form-control" placeholder="Email" name="email" autofocus />
                            <label for="password">Ingresa tu contraseña</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" />

                            <p class="text-right"><a href="#">Olvide mi contraseña</a></p>
                            <span class="clearfix"></span>
                        </div>
                        <div class="login-footer">
                            <div class="row">

                                <div class="col-xs-6 col-md-6 pull-right">
                                    <button type="submit" name="login" class="orange btn btn-large pull-right">
                                        Ingresar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
<section class="banner" id="center" style="background-image: url(img/fondo-naranja.png);">
<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="about-veno">
                        <div class="logo">
                            <img src="img/logo2.png" alt="Venue Logo">
                        </div>
                        <p>Proyecto Cafayate</p>
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="contact-info">
                        <div class="footer-heading">
                            <h4>Contacto</h4>
                        </div>
                        <p><i class="fa fa-map-marker"></i><a href="https://goo.gl/maps/nCDX4NmT6X7ogtHx8"><span>  Cafayate - Argentina</span></a></p>
                        <p><i class="fa fa-phone"></i><span>  Telefono:</span><a href="https://wa.me/543410000000?text=Hola">+54.000-000-0000</a></p>
                        <p><i class="fa fa-envelope"></i><span>  Correo:</span><a href="mailto:info@cafayate.com">info@cafayate.com</a></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <div class="footer-heading">
                            <h4>Nuestras Redes</h4>
                        </div>
                        <p><i class="fa fa-instagram"></i><a href="https://instagram.com"><span> Instagram</span></a></p>
                        <p><i class="fa fa-youtube"></i><a href="https:youtube.com"> Youtube </a></p>
                        <p><i class="fa fa-facebook"></i><a href="https:facebook.com"> Facebook</a></p>
                    </div>
                </div>
                
            </div>
        </div>
    </footer>


        <div class="sub-footer">
            <p>
                Copyright © 2022 Practica Profesionalizante II Di Benedetto - Barral
            </p>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
        <script>
            window.jQuery ||
                document.write(
                    '<script src="js/vendor/jquery-1.11.2.min.js"><\/script>'
                );
        </script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/datepicker.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    <?php
    }
    ?>
</body>

</html>
