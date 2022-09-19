<?php
require_once("validar_login.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
include_once("./utils/correo.php");
$usuario = $usuarios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
$listaSolis = $solicitudes->obtenerTodo();
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
    <link rel="stylesheet" href="css/perfil.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet" />

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <?php
    include_once("validaciones.php");

    if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['rechazar-soli']) or isset($_POST['aprobar-soli']))) {
        if (isset($_POST['aprobar-soli'])) {
            $data = explode("-", $_POST['aprobar-soli']);
            $uId = $data[1];
            $sId = $data[0];
            $uData = $usuarios->obtenerUno(["id_usuario"=>"'$uId'"])[1];
            $correo = $uData["correo"];
            $nombre = $uData["nombre"];
            $usuarios->actualizar(["id_rol" => "'3'"], ["id_usuario" => "'$uId'"]);
            $solicitudes->eliminar(["id_solicitud" => "'$sId'"]);
            $correos->aprobarSolicitud($correo, $nombre);
            $message = "La solicitud ha sido aprobada correctamente.";
            $redirect = "./solicitudes.php";
            require("result.php");
        } elseif (isset($_POST['rechazar-soli'])) {
            $data = explode("-", $_POST['rechazar-soli']);
            $uId = $data[1];
            $sId = $data[0];
            $uData = $usuarios->obtenerUno(["id_usuario"=>"'$uId'"])[1];
            $correo = $uData["correo"];
            $nombre = $uData["nombre"];
            $razon = $_POST["razon"];
            $solicitudes->eliminar(["id_solicitud" => "'$sId'"]);
            $correos->rechazarSolicitud($correo, $nombre, $razon);
            $redirect = "./solicitudes.php";
            $message = "La solicitud ha sido rechazada correctamente.";
            require("result.php");
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
                            <h2>Administrar: Solicitudes</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main>
            <div class="container">
                <div class="row">
                    <div class="profile">
                        <div class="col-md-3">
                            <div class="profile-sidebar">

                                <div class="profile-userpic">
                                    <img width="200px" height="200px" src="https://www.shareicon.net/data/512x512/2016/05/24/770137_man_512x512.png" class="img-responsive" alt="">
                                </div>

                                <div class="profile-usertitle">
                                    <div class="profile-usertitle-name">
                                        <?php echo ($usuario["nombre"] . " " . $usuario["apellido"]) ?>
                                    </div>
                                    <div class="profile-usertitle-role  ">
                                        [ <?php echo ($usuario["rol"]) ?> ]
                                    </div>
                                </div>

                                <?php
                                include_once("./perfil_lateral.php");
                                ?>

                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="profile-content">
                                <div class="row custyle">
                                    <table class="table table-striped custab">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Comercio</th>
                                                <th>Domicilio</th>
                                                <th>Propietario [ID]</th>
                                                <th>Fecha</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>

                                        <?php while ($soli = mysqli_fetch_assoc($listaSolis)) { ?>
                                            <tr>
                                                <td><?php echo ($soli["id_solicitud"]); ?></td>
                                                <td><?php echo ($soli["nombre"]); ?></td>
                                                <td><?php echo ($soli["domicilio"]); ?></td>
                                                <td><?php echo ($soli["propietario"] . " [" . $soli["id_usuario"] . "]"); ?></td>
                                                <td><?php echo ($soli["fecha"]); ?></td>
                                                <td class="text-center">
                                                    <form method="post" name="aprobar-soli">
                                                        <button class='btn btn-success btn-s' type="submit" name="aprobar-soli" value="<?php echo ($soli["id_solicitud"] . "-" . $soli["id_usuario"]); ?>">✔</button>
                                                        <button class='btn btn-danger btn-s' type="button" data-toggle="modal" href="#mi_modal-<?php echo($soli["id_solicitud"]); ?>">✘</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="mi_modal-<?php echo($soli["id_solicitud"]); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                                            </button>
                                                            <h4 class="modal-title" id="myModalLabel">Razón de rechazo [ID <?php echo($soli["id_solicitud"]); ?>]</h4>
                                                        </div>
                                                        <form method="post" name="rechazar-soli">
                                                        <div class="modal-body">
                                                            <div class="row" style="padding:15px">
                                                                <textarea name="razon" style="width: 100%;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                                <button class='btn btn-danger btn-s' type="submit" name="rechazar-soli" value="<?php echo ($soli["id_solicitud"] . "-" . $soli["id_usuario"]); ?>">Rechazar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </table>

                                    <?php if (mysqli_num_rows($listaSolis) === 0) { ?>
                                        <h3 class="text-center">
                                            <?php echo ("No hay ninguna solicitud.");  ?>
                                        </h3>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
