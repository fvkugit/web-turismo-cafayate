<?php

include_once("./utils/sessions.php");
include_once("./db/main.php");
$cats = $novedades_categorias->obtenerTodo();
$resn = 0;

function formatContenido($text)
{
    return ((strlen($text) < 125) ? $text : substr($text, 0, 125) . " [...]");
}

if (isset($_GET["fcat"])){
    $fcat = $_GET["fcat"];
}

if (isset($_GET["buscar"])) {
    $buscado = $_GET["buscar"];
    $listNovedades = $novedades->obtener(["titulo" => "'$buscado'"]);
    if ($buscado == "") unset($buscado);
} else {
    $listNovedades = $novedades->obtenerTodo();
}

$novUltimas = $novedades->obtenerTodo();

?>


<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Novedades</title>
    <?php include_once 'header.php'; ?>
</head>

<body>


    <?php include_once("./navbar.php"); ?>

    <section class="banner banner-secondary" id="top" style="background-image: url(img/Quebrada-de-cafayate.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Novedades</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-xs-12">
                        <?php if (isset($buscado)) { ?>
                            <h4 class="mb-5">Resultado de busqueda: <?php echo ($buscado); ?></h4>
                        <?php } ?>

                        <div class="row lista-grilla">

                            <?php while ($novedad = mysqli_fetch_assoc($listNovedades)) { if(isset($fcat)){if ($novedad["id_categoria"] != $fcat)continue;} $resn = 1; ?>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="featured-item">
                                        <div class="thumb">
                                            <div class="thumb-img">
                                                <img src=<?php echo (str_replace(' ', '%20', $novedad["imagen"])); ?> alt="">
                                            </div>

                                            <div class="overlay-content">
                                                <strong title="Publicado el"><i class="fa fa-calendar"></i> <?php echo ($novedad["fecha"]); ?></strong> 
                                            </div>
                                        </div>

                                        <div class="down-content">
                                            <h4><?php echo ($novedad["titulo"]); ?></h4>

                                            <div class="conte">
                                                <?php echo (formatContenido($novedad["contenido"])); ?>

                                            </div>
                                            <div class="text-button">
                                                <a href="./vernovedad.php?id=<?php echo ($novedad["id_novedad"]); ?>">LEER MÁS</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                        </div>
                        <?php if (mysqli_num_rows($listNovedades) === 0 || $resn == 0) { ?>
                            <h4 class="mb-5">No hay resultados para su busqueda</h4>
                        <?php } ?>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-12">
                        <div class="form-group">
                            <h4>Busqueda de Novedades</h4>
                            <form method="GET" name="buscar">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="buscar" style="height: 34px;" placeholder="Ingresa tu busqueda" value=<?php if(isset($buscado)){echo($buscado);} ?>>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                                </div>
                                <div class="form-group mt-2">
                                        <?php while ($cat = mysqli_fetch_assoc($cats)) { ?>
                                            <button class="btn btn-warning btn-sm" name="fcat" value=<?php echo ($cat["id_categoria"]); ?> type="submit"><?php echo ($cat["descripcion"]); ?></button>
                                        <?php } ?>
                                </div>
                            </form>
                        </div>
                        <br>

                        <div class="form-group">
                            <h4>Ultimas novedades</h4>
                        </div>
                        <?php $num_rows = 1; while ($novedad = mysqli_fetch_assoc($novUltimas)) { ?>
                            <?php if($num_rows > 3) break; $num_rows++;?>

                            <p><a href="./vernovedad.php?id=<?php echo ($novedad["id_novedad"]); ?>">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quae animi sint.</a></p>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        </section>
    </main>


    <?php include_once("./footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>

    <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>

</html>