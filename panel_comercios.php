<?php
require_once("validar_login.php");
include_once("./utils/validar_admin.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
include_once("./utils/correo.php");
$usuario = $usuarios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
$listaSolis = $comercios->obtenerTodo();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Comercios [Panel]</title>
    <?php include_once 'header.php'; ?>
</head>

<body>
    <?php
    include_once("validaciones.php");

    if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['comercio-eliminar']))) {
        $comId = $_POST['comercio-eliminar'];
        $uData = $comercios->eliminar(["id_comercio" => "'$comId'"])[1];
        print($uData);
        $redirect = "./panel_comercios.php";
        $message = "El comercio ha sido eliminado de la base de datos.";
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
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>

                                        <?php while ($soli = mysqli_fetch_assoc($listaSolis)) { ?>
                                            <tr>
                                                <td><?php echo ($soli["id_comercio"]); ?></td>
                                                <td><?php echo ($soli["nombre"]); ?></td>
                                                <td><?php echo ($soli["domicilio"]); ?></td>
                                                <td><?php echo ($soli["propietario"] . " [" . $soli["id_usuario"] . "]"); ?></td>
                                                <td class="text-center">
                                                    <form method="post" name="panel-comercios">
                                                        <!-- <button class='btn btn-success btn-s' type="submit" name="aprobar-soli" value="<?php echo ($soli["id_comercio"] . "-" . $soli["id_usuario"]); ?>"><span class="glyphicon glyphicon-edit"></span></button> -->
                                                        <button class='btn btn-danger btn-s' type="submit" name="comercio-eliminar" value="<?php echo ($soli["id_comercio"]); ?>" data-toggle="modal"><span class="glyphicon glyphicon-trash"></span></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="mi_modal-<?php echo($soli["id_comercio"]); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                                            </button>
                                                            <h4 class="modal-title" id="myModalLabel">Razón de rechazo [ID <?php echo($soli["id_comercio"]); ?>]</h4>
                                                        </div>
                                                        <form method="post" name="rechazar-soli">
                                                        <div class="modal-body">
                                                            <div class="row" style="padding:15px">
                                                                <textarea name="razon" style="width: 100%;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                                <button class='btn btn-danger btn-s' type="submit" name="rechazar-soli" value="<?php echo ($soli["id_comercio"] . "-" . $soli["id_usuario"]); ?>">Rechazar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </table>

                                    <?php if (mysqli_num_rows($listaSolis) === 0) { ?>
                                        <h3 class="text-center">
                                            <?php echo ("No hay ningún comercio.");  ?>
                                        </h3>
                                    <?php } ?>
                                </div>
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
    <?php
    }
    ?>
</body>

</html>