<?php
require_once("validar_login.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
include_once("./validaciones.php");
$usuario = $usuarios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
$comercio = $comercios->obtenerUno(["id_usuario"=>"'{$_SESSION['id']}'"])[1];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Proyecto Cafayate - Mi comercio</title>

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

    if (($_SERVER['REQUEST_METHOD'] === "POST") and (isset($_POST['solicitudcomercio']) or isset($_POST['guardarcomercio']))) {
        if (isset($_POST['solicitudcomercio'])) {
            $cuit = $_POST['cuit'];
            $nombre = $_POST['nombre'];
            $rubro = $_POST['rubro'];
            $domicilio = $_POST['domicilio'];
            $tel = $_POST['tel'];
            $id = $_SESSION['id'];
            $errorOnSubmit = false;
            $errors["cuit"] = validarCampo($cuit, "cuit");
            $errors["nombre"] = validarCampo($nombre, "nombre-comercio");
            $errors["rubro"] = validarCampo($rubro, "rubro");
            $errors["domicilio"] = validarCampo($domicilio, "domicilio");
            $errors["tel"] = validarCampo($tel, "tel");
            foreach ($errors as $e => $val) {
                if ($val != "") {
                    $errorOnSubmit = true;
                    break;
                }
            }
            unset($_POST['solicitudcomercio']);
            if (!$errorOnSubmit) {
                $res = $solicitudes->crear(["id_usuario" => "'$id'","id_categoria"=>"'1'", "nombre" => "'$nombre'", "rubro" => "'$rubro'", "domicilio" => "'$domicilio'", "telefono" => "'$tel'"]);
                if ($res[0]) {
                    $message = $res[1];
                    require("result.php");
                } else {
                }
            } else {
                require("micomercio.php");
            }
        }
        elseif(isset($_POST['guardarcomercio'])){
            $nombre = $_POST['nombre'];
            $domicilio = $_POST['domicilio'];
            $barrio = $_POST['barrio'];
            $descripcion = $_POST['descripcion'];
            $horarios = $_POST['horarios'];
            $id = $_SESSION['id'];
            $errorOnSubmit = false;
            $errors["nombre"] = validarCampo($nombre, "nombre-comercio");
            $errors["barrio"] = validarCampo($barrio, "nombre-comercio");
            $errors["domicilio"] = validarCampo($domicilio, "domicilio");
            $errors["descripcion"] = validarCampo($descripcion, "textarea");
            $errors["horarios"] = validarCampo($horarios, "textarea");
            foreach ($errors as $e => $val) {
                if ($val != "") {
                    $errorOnSubmit = true;
                    break;
                }
            }
            unset($_POST['guardarcomercio']);
            if (!$errorOnSubmit) {
                $res = $comercios->crear(["id_usuario"=>"'$id'","nombre"=>"'$nombre'","domicilio"=>"'$domicilio'","barrio"=>"'$barrio'","descripcion"=>"'$descripcion'","horarios"=>"'$horarios'"]);
                if ($res[0]) {
                    $message = "Los datos de su comercio han sido actualizados.";
                    $redirect = "./micomercio.php";
                    require("result.php");
                } else {
                }
            } else {
                require("micomercio.php");
            }
        }
    } else { ?>
        <?php include_once 'navbar.php'; ?>
        <section class="banner banner-secondary" id="top" style="background-image: url(img/banner-image-1-1920x3001.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="banner-caption">
                            <div class="line-dec"></div>
                            <h2>Mi comercio</h2>
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
                                <?php if ($usuario["rol"] === "Usuario") { ?>
                                    <?php if ($usuario["id_solicitud"]) { ?>
                                        <div class="mg-btm mx-auto">
                                            <h3 class="heading-desc">
                                                <span class="glyphicon glyphicon-time"></span> Su solicitud se encuentra pendiente de revisión
                                            </h3>
                                            <!-- <p class="info-desc text-red"><span class="glyphicon glyphicon-bell"></span> Usted no tiene el rol de comerciante requerido.</p> -->
                                            <p class="info-desc"><span class="glyphicon glyphicon-info-sign"></span> El equipo encargado de comercios corroborara los datos de su solicitud y se le notificara la resolución de la misma, en caso de ser aprobada podrá actualizar comercio en este apartado.</p>

                                        <?php } else { ?>
                                            <form method="POST" name="solicitudcomercio">
                                                <div class="mg-btm mx-auto">
                                                    <h3 class="heading-desc">
                                                        Solicitud para perfil de comerciante
                                                    </h3>
                                                    <p class="info-desc text-red"><span class="glyphicon glyphicon-bell"></span> Usted no tiene el rol de comerciante requerido.</p>
                                                    <p class="info-desc"><span class="glyphicon glyphicon-info-sign"></span> Al completar este formulario, enviaras una solicitud para
                                                        obtener rol de comerciante dentro de nuestro sitio web. Tan pronto como la administración tome una decisión sobre tu solcitud, recibiras
                                                        un correo electronico informandote.</p>
                                                    <?php if (isset($error)) { ?>
                                                        <h3 class="heading-desc text-red">
                                                            <?php echo ($error) ?>
                                                        </h3>
                                                    <?php } ?>

                                                    <div class="main">
                                                        <label for="cuit">CUIT del comercio</label>
                                                        <span>(Sin guiones)</span>
                                                        <input type="text" class="form-control" name="cuit" autofocus />
                                                        <p class="text-red"><?php if (isset($errors['cuit'])) {
                                                                                echo $errors['cuit'];
                                                                            }  ?></p>
                                                        <label for="nombre">Nombre del comercio</label>
                                                        <input type="text" class="form-control" name="nombre" />
                                                        <p class="text-red"><?php if (isset($errors['nombre'])) {
                                                                                echo $errors['nombre'];
                                                                            }  ?></p>
                                                        <label for="rubro">Rubro del comercio</label>
                                                        <input type="text" class="form-control" name="rubro" />
                                                        <p class="text-red"><?php if (isset($errors['rubro'])) {
                                                                                echo $errors['rubro'];
                                                                            }  ?></p>
                                                        <label for="domicilio">Domicilio del comercio</label>
                                                        <input type="text" class="form-control" name="domicilio" />
                                                        <p class="text-red"><?php if (isset($errors['domicilio'])) {
                                                                                echo $errors['domicilio'];
                                                                            }  ?></p>
                                                        <label for="tel">Telefono de contacto</label>
                                                        <span>(Nos contactaremos para validar tus datos por este medio.)</span>
                                                        <input type="text" class="form-control" name="tel" />
                                                        <p class="text-red"><?php if (isset($errors['tel'])) {
                                                                                echo $errors['tel'];
                                                                            }  ?></p>

                                                        <span class="clearfix"></span>
                                                    </div>
                                                    <div class="login-footer">
                                                        <div class="row">

                                                            <div class="col-xs-6 col-md-6 pull-right">
                                                                <button type="submit" name="solicitudcomercio" class="orange btn btn-large pull-right">
                                                                    Enviar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <form method="POST" name="guardarcomercio">
                                            <div class="mg-btm mx-auto">
                                                <h3 class="heading-desc">
                                                    Editar datos de su comercio
                                                </h3>

                                                <?php if (isset($error)) { ?>
                                                    <h3 class="heading-desc text-red">
                                                        <?php echo ($error) ?>
                                                    </h3>
                                                <?php } ?>

                                                <div class="main">
                                                    <label for="nombre">Nombre</label>
                                                    <input type="text" class="form-control" name="nombre" value="<?php if(isset($comercio["id_comercio"])){echo($comercio['nombre']);}; ?>" autofocus />
                                                    <p class="text-red"><?php if (isset($errors['nombre'])) {
                                                                            echo $errors['nombre'];
                                                                        }  ?></p>
                                                    <label for="barrio">Barrio</label>
                                                    <input type="text" class="form-control" name="barrio" value="<?php if(isset($comercio["id_comercio"])){echo($comercio['barrio']);}; ?>"/>
                                                    <p class="text-red"><?php if (isset($errors['barrio'])) {
                                                                            echo $errors['barrio'];
                                                                        }  ?></p>
                                                    <label for="domicilio">Domicilio del comercio</label>
                                                    <input type="text" class="form-control" name="domicilio" value="<?php if(isset($comercio["id_comercio"])){echo($comercio['domicilio']);}; ?>"/>
                                                    <p class="text-red"><?php if (isset($errors['domicilio'])) {
                                                                            echo $errors['domicilio'];
                                                                        }  ?></p>

                                                    <label for="descripcion">Descripción</label>
                                                    <textarea class="ckeditor" name="descripcion"><?php if(isset($comercio["id_comercio"])){echo($comercio['descripcion']);}; ?></textarea>
                                                    <p class="text-red"><?php if (isset($errors['descripcion'])) {
                                                                            echo $errors['descripcion'];
                                                                        }  ?></p>

                                                    <label for="horarios">Horarios</label>
                                                    <textarea class="ckeditor" name="horarios"><?php if(isset($comercio["id_comercio"])){echo($comercio['horarios']);}; ?></textarea>
                                                    <p class="text-red"><?php if (isset($errors['horarios'])) {
                                                                            echo $errors['horarios'];
                                                                        }  ?></p>


                                                    <span class="clearfix"></span>
                                                </div>
                                                <div class="login-footer">
                                                    <div class="row">

                                                        <div class="col-xs-6 col-md-6 pull-right">
                                                            <button type="submit" name="guardarcomercio" class="orange btn btn-large pull-right">
                                                                Guardar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
        </main>

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
                    <div class="col-md-4">
                        <div class="useful-links">
                            <div class="footer-heading">
                                <h4>Enlaces Utiles </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li><a href="inicio.html"><i class="fa fa-stop"></i>Inicio</a></li>
                                        <li><a href="comercios.html"><i class="fa fa-stop"></i>Comercios</a></li>
                                        <li><a href="novedades.html"><i class="fa fa-stop"></i>Novedades</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li><a href="turismo.html"><i class="fa fa-stop"></i>Turismo</a></li>
                                        <!-- / #rellenar con los faltantes -->
                                        <li><a href="xxx.html"><i class="fa fa-stop"></i>Ingresar</a></li>
                                        <li><a href="xxx.html"><i class="fa fa-stop"></i>xxxxx</a></li>
                                        <!-- / #rellenar con los faltantes -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="contact-info">
                            <div class="footer-heading">
                                <h4>Informacion de Contacto</h4>
                            </div>
                            <p><i class="fa fa-map-marker"></i> Cafayate - Argentina</p>
                            <ul>
                                <li><span>Telefono:</span><a href="#">+54.000-000-0000</a></li>
                                <li><span>Correo:</span><a href="#">info@cafayate.com</a></li>
                            </ul>
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
        <script src="utils/ckeditor/ckeditor.js"></script>
    <?php } ?>
</body>

</html>