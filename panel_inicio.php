<?php
require_once("./validar_login.php");
require_once("./utils/validar_admin.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
$usuario = $usuarios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
$datapublica = $dpublica->obtenerUno("")[1];
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

    if (($_SERVER['REQUEST_METHOD'] === "POST") && isset($_POST["bienvenida"])) {
        $texto = $_POST["bienvenida"];
        $nId = $datapublica["id"];
        $dpublica->actualizar(["bienvenida"=>"'$texto'"], ["id"=>"'$nId'"]);
        $redirect = "./panel_inicio.php";
        $message = "La información ha sido modificada.";
        require("result.php");
    } else {
    ?>
        <?php include_once 'navbar.php'; ?>

        <section class="banner banner-secondary" id="top" style="background-image: url(img/banner-image-1-1920x3001.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="banner-caption">
                            <div class="line-dec"></div>
                            <h2>Administrar: Inicio</h2>
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
                                <form method="POST" name="actualizarbienvenida">
                                    <textarea id="ckeditor" class="ckeditor" name="bienvenida"><?php echo ($datapublica["bienvenida"]); ?></textarea>
                                    <div class="col-xs-6 col-md-6 pull-right">
                                        <button type="submit" name="actualizarbienvenida" class="orange btn btn-large pull-right mt-5">
                                            Actualizar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include_once("./footer.php"); ?>

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
        <script src="utils/ckeditor/ckeditor.js"></script>

    <?php
    }
    ?>

</body>

</html>
