<?php

include_once("./utils/sessions.php");
include_once("./db/main.php");
if (!isset($_GET["id"])){
    $message = "El comercio no existe.";
    $redirect = "./comercios.php";
    require("result.php");
}
$ver_id = $_GET["id"];
$comercioRaw = $comercios->obtenerUno(["id_comercio" => $ver_id]);
$comercioData = $comercioRaw[1];
if (!isset($comercioData["id_comercio"])) {
    $message = "El comercio no existe.";
    $redirect = "./comercios.php";
    require("result.php");
} else {
    $id_com = $comercioData["id_comercio"];
    $comercioImagenes = $comercios_imagenes->obtener(["id_comercio" => "'$id_com'"]);
    $primerImagen = $comercioImagenes->fetch_array();
    $portada = @$primerImagen["url"] ?: "./image/placeholder.png";

    $embedUrl = "https://www.google.com/maps?q=" . $comercioData["domicilio"] . ", Cafayate, Salta, Argentina.&output=embed";
    $embedUrl = str_replace(' ', '%20', $embedUrl);
}

?>
<?php if(isset($comercioData["id_comercio"])){ ?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Comercio</title>
    <?php include_once 'header.php'; ?>
</head>


<body>

<?php include_once 'navbar.php'; ?>

    <section class="banner banner-secondary" id="top" style="background-image: url(img/banner-image-1-1920x3001.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Comercios de Cafayate</h2>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div>
                            <img src=<?php echo ($portada); ?> alt="" class="img-responsive wc-image">
                        </div>
                        <br>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h2><strong class="text-primary"><?php echo ($comercioData["nombre"]); ?></strong></h2>

                        <h2><small><i class="fa fa-map-marker"></i> <?php echo ($comercioData["domicilio"]); ?></small></h2>

                        <br>

                        <div class="row">
                            <?php while ($img = mysqli_fetch_assoc($comercioImagenes)) { ?>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <img class="imagen-grilla" src=<?php echo ($img["url"]); ?> alt="" class="img-responsive">
                                    </div>
                                </div>
                            <?php } ?>


                        </div>
                    </div>
                </div>

                <form action="#" method="post" class="form">
                    <div class="accordions">
                        <ul class="accordion">
                            <li>
                                <a class="accordion-trigger">Descripcion del comercio</a>

                                <div class="accordion-content">
                                    <?php echo ($comercioData["descripcion"]); ?>
                                </div>
                            </li>
                            <li>
                                <a class="accordion-trigger">Horarios Disponibles</a>

                                <div class="accordion-content">
                                    <?php echo ($comercioData["horarios"]); ?>
                                </div>
                            </li>


                            <li>
                                <a class="accordion-trigger">Ubicaci??n</a>

                                <iframe src=<?php echo ($embedUrl); ?> width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

                    </div>
                    </li>

                    </ul> <!-- / accordion -->
            </div>
            </form>
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
<?php } ?>