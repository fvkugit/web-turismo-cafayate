<?php
require_once("validar_login.php");
include_once("./utils/sessions.php");
include_once("./db/main.php");
$usuario = $usuarios->obtenerUno(["id_usuario" => "'{$_SESSION['id']}'"])[1];
$listaSolis = $novedades->obtenerTodo();
$cats = $novedades_categorias->obtenerTodo();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Novedades [Panel]</title>
    <?php include_once 'header.php'; ?>
</head>

<body>
    <?php
    include_once("validaciones.php");
    if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['nov-eliminar']) || isset($_POST['nov-editar']) || isset($_POST["nov-publicar"]))) {
        if (isset($_POST['aprobar-soli'])) {
            $data = explode("-", $_POST['aprobar-soli']);
            $uId = $data[1];
            $sId = $data[0];
            $solicitudes->eliminar(["id_solicitud" => "'$sId'"]);
            $usuarios->actualizar(["id_rol" => "'3'"], ["id_usuario" => "'$uId'"]);
            $message = "La solicitud ha sido aprobada correctamente.";
            $redirect = "./solicitudes.php";
            require("result.php");
        } elseif (isset($_POST['rechazar-soli'])) {
            $sId = $_POST['rechazar-soli'];
            $solicitudes->eliminar(["id_solicitud" => "'$sId'"]);
            $redirect = "./solicitudes.php";
            $message = "La solicitud ha sido rechazada correctamente.";
            require("result.php");
        } elseif (isset($_POST['nov-publicar'])){
            $titulo = $_POST["titulo"];
            $contenido = $_POST["contenido"];
            $cat = $_POST["categoria"];
            $filename = "nov-" . $titulo . "-" . $_FILES["portada"]["name"];
            $tempname = $_FILES["portada"]["tmp_name"];
            $folder = "./image/nov/" . $filename;
            if (move_uploaded_file($tempname, $folder)) {
                $nuevopost = $novedades->crear(["titulo"=>"'$titulo'", "contenido"=>"'$contenido'", "id_categoria"=>"'$cat'", "imagen"=>"'$folder'"]);
                print_r($nuevopost);

            } else {
                $message = "Error al cargar los datos.";
                $redirect = "./panel_novedades.php";
                require("result.php");
            }
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
                            <h2>Administrar: Novedades</h2>
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
                                <?php if (!isset($_POST["nov-crear"])) { ?>
                                    <div class="row custyle">
                                        <table class="table table-striped custab">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Titulo</th>
                                                    <th>Categoria</th>
                                                    <th>Fecha</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <?php while ($soli = mysqli_fetch_assoc($listaSolis)) { ?>
                                                <tr>
                                                    <td><?php echo ($soli["id_novedad"]); ?></td>
                                                    <td><?php echo ($soli["titulo"]); ?></td>
                                                    <td><?php echo ($soli["cat"]); ?></td>
                                                    <td><?php echo ($soli["fecha"]); ?></td>
                                                    <td class="text-center">
                                                        <form method="post" name="nov-post">
                                                            <button class='btn btn-info btn-s' type="submit" name="nov-editar" value="<?php echo ($soli["id_novedad"] . "-" . $soli["id_usuario"]); ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                                            <button class='btn btn-danger btn-s' type="submit" name="nov-eliminar" value="<?php echo ($soli["id_novedad"] . "-" . $soli["id_usuario"]); ?>"><span class="glyphicon glyphicon-trash"></span></button>
                                                            <a href="./vernovedad.php?id=<?php echo ($soli["id_novedad"]); ?>"><button class='btn btn-success btn-s' type="button"><span class="glyphicon glyphicon-eye-open"></button></a>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </table>

                                    </div>
                                    <form method="post" name="nov-post">
                                        <button type="submit" name="nov-crear" value="1" class="btn btn-success btn-sm btn-block"><span class="glyphicon glyphicon-plus"></span> Agregar nueva noticia</button>
                                    </form>
                                <?php } else { ?>
                                    <div class="mg-btm mx-auto">
                                        <form method="POST" name="nov-publicar" enctype="multipart/form-data">
                                            <h3 class="heading-desc">
                                                Crear nueva novedad
                                            </h3>

                                            <?php if (isset($error)) { ?>
                                                <h3 class="heading-desc text-red">
                                                    <?php echo ($error) ?>
                                                </h3>
                                            <?php } ?>

                                            <div class="main">
                                                <label for="titulo">Titulo</label>
                                                <input type="text" class="form-control" name="titulo" autofocus />
                                                <p class="text-red"><?php if (isset($errors['titulo'])) {
                                                                        echo $errors['titulo'];
                                                                    }  ?></p>

                                                <div class="form-group">
                                                    <label for="categoria">Categoria</label>
                                                    <select class="form-control" id="categoria" name="categoria">
                                                        <?php while ($cat = mysqli_fetch_assoc($cats)) { ?>
                                                            <option value=<?php echo ($cat["id_categoria"]); ?>><?php echo ($cat["descripcion"]); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <label for="contenido">Contenido</label>
                                                <textarea class="ckeditor" name="contenido"></textarea>
                                                <p class="text-red"><?php if (isset($errors['contenido'])) {
                                                                        echo $errors['contenido'];
                                                                    }  ?></p>


                                                <label for="cargarimagen">Portada</label>

                                                <div class="uploader">
                                                    <input type="file" class="form-control" name="portada">
                                                    <p style="margin-top: -55px">Arrastra tu imagen o presiona aquí.</p>
                                                </div>



                                            </div>
                                            <div class="">
                                                <div class="row">

                                                    <div class="col-xs-6 col-md-6 pull-right">
                                                        <button type="submit" name="nov-publicar" class="orange btn btn-large pull-right">
                                                            Guardar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

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
    <?php
    }
    ?>
</body>

</html>