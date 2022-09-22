<?php
require_once("validar_login.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
include_once("./validaciones.php");
$usuario = $usuarios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
$comercio = $comercios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
$desc = '<ul> <li> <p><strong>Historia</strong></p> <p>Donec dapibus semper sem, ac ultrices sem sagittis ut. Donec sit amet erat elit, sed pellentesque odio. In enim ligula, euismod a adipiscing in, laoreet quis turpis. Ut accumsan dignissim rutrum.</p> </li> <li> <p><strong>Certificados</strong></p> <p>Donec dapibus semper sem, ac ultrices sem sagittis ut. Donec sit amet erat elit, sed pellentesque odio. In enim ligula, euismod a adipiscing in, laoreet quis turpis. Ut accumsan dignissim rutrum.</p> </li> <li> <p><strong>Telefono</strong></p> <p>+54 341 000 0000</p> </li> <li> <p><strong>Direccion</strong></p> <p>Av. Eva peron 557</p> </li> <li> <p><strong>Redes Sociales</strong></p> <p>www.comercio1.com<br /> www.instagram.com/comercio1<br /> www.facebook.com/comercio1</p> </li> </ul> ';
$hor = '<table border="0" cellpadding="0" cellspacing="0" style="width:100%"> <thead> <tr> <th>Horarios Semanales</th> <th>Lunes a Viernes</th> <th>Sabado, Domingo y Feriados</th> </tr> </thead> <tbody> <tr> <td>&nbsp;</td> <td>08:00 hs a 17:00 hs</td> <td>08:00 hs a 17:00 hs</td> </tr> <tr> <td>&nbsp;</td> <td>08:00 hs a 17:00 hs</td> <td>08:00 hs a 17:00 hs</td> </tr> <tr> <td>&nbsp;</td> <td>08:00 hs a 17:00 hs</td> <td>08:00 hs a 17:00 hs</td> </tr> </tbody> </table> ';
if (isset($comercio["id_comercio"])){
    $id_com = $comercio["id_comercio"];
    $imagenes = $comercios_imagenes->obtener(["id_comercio"=>"'$id_com'"]);
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Mi Comercio</title>
    <?php include_once 'header.php'; ?>
</head>


<body>
    <?php

    if (($_SERVER['REQUEST_METHOD'] === "POST") and (isset($_POST['solicitudcomercio']) || isset($_POST['guardarcomercio']) || isset($_POST['cargarimagen']) || isset($_POST['eliminarimagen']))) {
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
                $res = $solicitudes->crear(["id_usuario" => "'$id'", "nombre" => "'$nombre'", "rubro" => "'$rubro'", "domicilio" => "'$domicilio'", "telefono" => "'$tel'"]);
                if ($res[0]) {
                    $message = "Solicitud realizada con exito.";
                    require("result.php");
                } else {
                }
            } else {
                require("micomercio.php");
            }
        } elseif (isset($_POST['guardarcomercio'])) {
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
                $res = $comercios->crear(["id_usuario" => "'$id'", "nombre" => "'$nombre'", "domicilio" => "'$domicilio'", "barrio" => "'$barrio'", "descripcion" => "'$descripcion'", "horarios" => "'$horarios'"]);
                if ($res[0]) {
                    $message = "Los datos de su comercio han sido actualizados.";
                    $redirect = "./micomercio.php";
                    require("result.php");
                } else {
                }
            } else {
                require("micomercio.php");
            }
        } elseif (isset($_POST['cargarimagen']) and isset($_FILES['imagencargada'])) {
            $id_com = $comercio['id_comercio'];
            $filename = $_SESSION['id'] . "-" . $id_com . "-" . $_FILES["imagencargada"]["name"];
            $tempname = $_FILES["imagencargada"]["tmp_name"];
            $folder = "./image/" . $filename;
            if (move_uploaded_file($tempname, $folder)) {
                $comercios_imagenes->crear(["id_comercio"=>"'$id_com'", "nombre"=>"'$filename'", "url"=>"'$folder'"]);
                $message = "La imagen se ha cargado con exito.";
                $redirect = "./micomercio.php";
                require("result.php");

            } else {
                $message = "Error al cargar la imagen.";
                $redirect = "./micomercio.php";
                require("result.php");
            }
        } elseif (isset($_POST['eliminarimagen'])){
            $id_eliminada = $_POST['eliminarimagen'];
            $res = $comercios_imagenes->eliminar(["id_imagen"=>"'$id_eliminada'"]);
            if ($res[0]) {
                $message = "La imagen se ha eliminado con exito.";
                $redirect = "./micomercio.php";
                require("result.php");

            } else {
                $message = "Error al eliminar la imagen.";
                $redirect = "./micomercio.php";
                require("result.php");
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
                                        <div class="mg-btm mx-auto">
                                            <form method="POST" name="guardarcomercio">
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
                                                    <input type="text" class="form-control" name="nombre" value="<?php if (isset($comercio["id_comercio"])) {
                                                                                                                        echo ($comercio['nombre']);
                                                                                                                    }; ?>" autofocus />
                                                    <p class="text-red"><?php if (isset($errors['nombre'])) {
                                                                            echo $errors['nombre'];
                                                                        }  ?></p>
                                                    <label for="barrio">Barrio</label>
                                                    <input type="text" class="form-control" name="barrio" value="<?php if (isset($comercio["id_comercio"])) {
                                                                                                                        echo ($comercio['barrio']);
                                                                                                                    }; ?>" />
                                                    <p class="text-red"><?php if (isset($errors['barrio'])) {
                                                                            echo $errors['barrio'];
                                                                        }  ?></p>
                                                    <label for="domicilio">Domicilio del comercio</label>
                                                    <input type="text" class="form-control" name="domicilio" value="<?php if (isset($comercio["id_comercio"])) {
                                                                                                                        echo ($comercio['domicilio']);
                                                                                                                    }; ?>" />
                                                    <p class="text-red"><?php if (isset($errors['domicilio'])) {
                                                                            echo $errors['domicilio'];
                                                                        }  ?></p>

                                                    <label for="descripcion">Descripción</label>
                                                    <textarea class="ckeditor" name="descripcion"><?php if (isset($comercio["id_comercio"])) {
                                                                                                        echo ($comercio['descripcion']);
                                                                                                    }else{echo($desc);} ?></textarea>
                                                    <p class="text-red"><?php if (isset($errors['descripcion'])) {
                                                                            echo $errors['descripcion'];
                                                                        }  ?></p>

                                                    <label for="horarios">Horarios</label>
                                                    <textarea class="ckeditor" name="horarios"><?php if (isset($comercio["id_comercio"])) {
                                                                                                    echo ($comercio['horarios']);
                                                                                                }else{echo($hor);} ?></textarea>
                                                    <p class="text-red"><?php if (isset($errors['horarios'])) {
                                                                            echo $errors['horarios'];
                                                                        }  ?></p>



                                                </div>
                                                <div class="">
                                                    <div class="row">

                                                        <div class="col-xs-6 col-md-6 pull-right">
                                                            <button type="submit" name="guardarcomercio" class="orange btn btn-large pull-right">
                                                                Guardar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                            <div class="mg-btm mx-auto mt-5 main">
                                                <label for="cargarimagen">Cargar imagen</label>

                                                <div class="uploader">
                                                    <form method="POST" name="cargarimagen" enctype="multipart/form-data">
                                                        <input type="file" class="form-control" name="imagencargada">
                                                        <p>Arrastra tu imagen o presiona aquí.</p>
                                                        <button type="submit" name="cargarimagen"><span class="glyphicon glyphicon-cloud-upload"></span> Cargar</button>
                                                    </form>
                                                </div>

                                                <label for="">Imagenes del comercio</label>
                                
                                                <div class="row">
                                                    <?php if(isset($imagenes)){ ?>
                                                    <?php while ($img = mysqli_fetch_assoc($imagenes)) { ?>
                                                    <div class="col-sm-4 col-xs-6">
                                                        <div class="form-group">
                                                        <img class="imagen-grilla" src=<?php echo($img["url"]); ?> alt="" class="img-responsive">
                                                        <form method="POST" name="eliminarimagen">
                                                            <button type="submit" name="eliminarimagen" value=<?php echo($img["id_imagen"]) ?> class="btn btn-danger btn-sm btn-block"><span class="glyphicon glyphicon-trash"></span> Eliminar </button>
                                                        </form>
                                                            
                                                        </div>
                                                    </div>
                                                    <?php } } ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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
    <?php } ?>
</body>

</html>