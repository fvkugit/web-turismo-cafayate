<?php
require_once("validar_login.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
$usuario = $usuarios->obtenerUno(["id_usuario"=>"'{$_SESSION['id']}'"])[1];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Mi Perfil</title>
    <?php include_once 'header.php'; ?>
</head>

<body>
    <?php
    include_once("validaciones.php");
    if (($_SERVER['REQUEST_METHOD'] === "POST") and (isset($_POST['actualizarperfil']))) {
        $nombre = $_POST['name'];
        $apellido = $_POST['lastname'];
        $dni = $_POST['dni'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $id = $_SESSION['id'];
        $errorOnSubmit = false;
        $errors["email"] = validarCampo($email, "email");
        $errors["name"] = validarCampo($nombre, "name");
        $errors["lastname"] = validarCampo($apellido, "lastname");
        $errors["tel"] = validarCampo($tel, "tel");
        $errors["dni"] = validarCampo($dni, "dni");
        foreach ($errors as $e => $val) {
            if ($val != ""){ $errorOnSubmit = true; break; }
        }
        unset($_POST['actualizarperfil']);
        if (!$errorOnSubmit) { 
            $res = $usuarios->actualizar(["nombre"=>"'$nombre'", "apellido"=>"'$apellido'", "telefono"=>"'$tel'", "correo"=>"'$email'", "dni"=>"'$dni'"], ["id_usuario"=>"$id"]);
            if ($res[0]){
                $message = "Los datos han sido actualizado con exito.";
                require("miperfil.php");
            }else{
                $error = "Error al actualizar los datos.";
                require("miperfil.php");
            }
        } else {
            require("miperfil.php");
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
                            <h2>Mi perfil</h2>
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
                                        <?php echo($usuario["nombre"] . " " . $usuario["apellido"]) ?>
                                    </div>
                                    <div class="profile-usertitle-role  ">
                                        [ <?php echo($usuario["rol"]) ?> ]
                                    </div>
                                </div>

                                <?php 
                                    include_once("./perfil_lateral.php");
                                ?>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="profile-content">
                            <form method="POST" name="actualizarperfil" class="mg-btm mx-auto">
                                        <h3 class="heading-desc">
                                            Mis datos
                                        </h3>
                                        <?php if (isset($message)) { ?>
                                            <p class="heading-desc text-green"><span class="glyphicon glyphicon-ok"></span> <?php echo($message) ?> </p>                                  
                                        <?php } ?> 
                                        <?php if (isset($error)) { ?>
                                            <p class="heading-desc text-red"><span class="glyphicon glyphicon-remove"></span> <?php echo($error) ?> </p>                                  
                                        <?php } ?> 
                                        <div class="main">
                                            <label for="name">Nombre</label>
                                            <input type="text" class="form-control" name="name" placeholder="Nombre" autofocus value="<?php echo $usuario['nombre']; ?>" />
                                            <p class="text-red"><?php if (isset($errors['name'])) {
                                                                    echo $errors['name'];
                                                                }  ?></p>
                                            <label for="name">Apellido</label>
                                            <input type="text" class="form-control" name="lastname" placeholder="Apellido" value="<?php echo $usuario['apellido']; ?>" />
                                            <p class="text-red"><?php if (isset($errors['lastname'])) {
                                                                    echo $errors['lastname'];
                                                                }  ?></p>
                                            <label for="name">Documento (DNI)</label>
                                            <input type="text" class="form-control" name="dni" placeholder="Documento" value="<?php echo $usuario['dni']; ?>" />
                                            <p class="text-red"><?php if (isset($errors['dni'])) {
                                                                    echo $errors['dni'];
                                                                }  ?></p>
                                            <label for="name">Telefono</label>
                                            <input type="text" class="form-control" name="tel" placeholder="Telefono 3868-xxxxxxx" value="<?php echo $usuario['telefono']; ?>" />
                                            <p class="text-red"><?php if (isset($errors['tel'])) {
                                                                    echo $errors['tel'];
                                                                }  ?></p>
                                            <label for="email">Correo electronico</label>
                                            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $usuario['correo']; ?>" />
                                            <p class="text-red"><?php if (isset($errors['email'])) {
                                                                    echo $errors['email'];
                                                                }  ?></p>
                                            <span class="clearfix"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-md-6">

                                            </div>
                                            <div class="col-xs-6 col-md-6 pull-right">
                                                <button type="submit" name="actualizarperfil" class="orange btn btn-large pull-right">
                                                    Actualizar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <?php include_once("./footer.php"); ?>


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
