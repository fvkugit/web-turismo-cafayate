<?php
require_once("validar_login.php");
include_once("./utils/validar_admin.php");
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
    if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['nov-eliminar']) || isset($_POST["nov-publicar"]))) {
        if (isset($_POST['nov-eliminar'])) {
            $ide = htmlspecialchars($_POST['nov-eliminar']);
            $res = $novedades->eliminar(["id_novedad" => "'$ide'"]);
            if ($res[0]) {
                $message = "La novedad ha sido eliminada correctamente.";
                $redirect = "./panel_novedades.php";
                require("result.php");
            } else {
                $message = "Hubo un error al intentar eliminar la novedad.";
                $redirect = "./panel_novedades.php";
                require("result.php");
            }
        } elseif (isset($_POST['nov-publicar'])) {
            $errorOnSubmit = false;
            $titulo = htmlspecialchars($_POST["titulo"]);
            $contenido = $_POST["contenido"];
            $cat = htmlspecialchars($_POST["categoria"]);
            $idEdit = @$_POST["nov-editar"];
            $errors["titulo"] = validarCampo($titulo, "nombre-comercio");
            $errors["contenido"] = validarCampo($contenido, "textarea");
            // $errors["cat"] = validarCampo($apellido, "lastname");
            if(!isset($idEdit)){
                if ($_FILES["portada"]["size"] === 0) $errors["portada"] = "Debes cargar una imagen";
            }
            foreach ($errors as $e => $val) {
                if ($val != "") {
                    $errorOnSubmit = true;
                    break;
                }
            }
            unset($_POST['nov-publicar']);
            $_POST["nov-crear"] = 1;
            if (!$errorOnSubmit) {
                $filename = "nov-" . $titulo . "-" . $_FILES["portada"]["name"];
                $tempname = $_FILES["portada"]["tmp_name"];
                $folder = "./image/nov/" . $filename;
                if (isset($idEdit)) {
                    $qData = ["titulo" => "'$titulo'", "contenido" => "'$contenido'", "id_categoria" => "'$cat'", "imagen" => "'$folder'", "id_novedad" => "'$idEdit'"];
                } else {
                    $qData = ["titulo" => "'$titulo'", "contenido" => "'$contenido'", "id_categoria" => "'$cat'", "imagen" => "'$folder'"];
                }
                if($idEdit && ($_FILES["portada"]["size"] == 0)){
                    $imgEdit = $_POST["portada"];
                    $qData["imagen"] = "'{$imgEdit}'";
                    $nuevopost = $novedades->crear($qData);
                    $message = "Novedad actualizada.";
                    $redirect = "./panel_novedades.php";
                    require("result.php");
                }else{
                    if (move_uploaded_file($tempname, $folder)) {
                        $nuevopost = $novedades->crear($qData);
                        $message = "Novedad actualizada.";
                        $redirect = "./panel_novedades.php";
                        require("result.php");
                    } else {
                        $message = "Error al cargar los datos.";
                        $redirect = "./panel_novedades.php";
                        require("result.php");
                    }
                }
            } else {
                require("panel_novedades.php");
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
                                <?php if (!isset($_POST["nov-crear"]) && !isset($_POST["nov-editar"])) { ?>
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
                                                            <button class='btn btn-info btn-s' type="submit" name="nov-editar" value="<?php echo ($soli["id_novedad"]); ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                                            <button class='btn btn-danger btn-s' type="submit" name="nov-eliminar" value="<?php echo ($soli["id_novedad"]); ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
                                <?php } else {
                                    if (isset($_POST["nov-editar"])) {
                                        $eId = $_POST["nov-editar"];
                                        $dataEditar = $novedades->obtenerUno(["id_novedad" => "'$eId'"])[1];
                                    }
                                ?>
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
                                                <input type="text" class="form-control" name="titulo" autofocus value="<?php if (isset($_POST["nov-editar"])) {
                                                                                                                            echo ($dataEditar["titulo"]);
                                                                                                                        } ?>" />
                                                <p class="text-red"><?php if (isset($errors['titulo'])) {
                                                                        echo $errors['titulo'];
                                                                    }  ?></p>

                                                <div class="form-group">
                                                    <label for="categoria">Categoria</label>
                                                    <select class="form-control" id="categoria" name="categoria">
                                                        <?php while ($cat = mysqli_fetch_assoc($cats)) { ?>

                                                            <option <?php if (isset($_POST["nov-editar"])) {
                                                                        echo (($cat["id_categoria"] == $dataEditar["id_categoria"]) ? "selected='true'" : '');
                                                                    } ?> value=<?php echo ($cat["id_categoria"]); ?>><?php echo ($cat["descripcion"]); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <label for="contenido">Contenido</label>
                                                <textarea class="ckeditor" name="contenido">
                                                    <?php if (isset($_POST["nov-editar"])) {
                                                        echo ($dataEditar["contenido"]);
                                                    } ?>
                                                </textarea>
                                                <p class="text-red"><?php if (isset($errors['contenido'])) {
                                                                        echo $errors['contenido'];
                                                                    }  ?></p>


                                                <label for="cargarimagen">Portada</label>
                                                <p class="text-red"><?php if (isset($errors['portada'])) {
                                                                        echo $errors['portada'];
                                                                    }  ?></p>

                                                <div class="uploader">
                                                    <input type="file" class="form-control" name="portada">
                                                    <p style="margin-top: -55px">Arrastra tu imagen o presiona aquí.</p>
                                                </div>

                                                <?php if (isset($_POST["nov-editar"])) { ?>
                                                    <input type='hidden' name='nov-editar' value=<?php echo ($_POST["nov-editar"]); ?>>
                                                    <input type='hidden' name='portada' value=<?php echo ($dataEditar["imagen"]); ?>>
                                                <?php } ?>

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