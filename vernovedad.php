<?php

include_once("./utils/sessions.php");
include_once("./db/main.php");
if (!isset($_GET["id"])){
    $message = "La novedad no existe.";
    $redirect = "./novedades.php";
    require("result.php");
}
$ver_id = $_GET["id"];
$novedadRaw = $novedades->obtenerUno(["id_novedad"=> $ver_id]);
$novedadData = $novedadRaw[1];
if (!isset($novedadData["id_novedad"])) {
    $message = "La novedad no existe.";
    $redirect = "./novedades.php";
    require("result.php");
} 

?>
<?php if(isset($novedadData["id_novedad"])){ ?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Comercio</title>
    <?php include_once 'header.php'; ?>
</head>


<body>

    <?php include_once 'navbar.php'; ?>

    <section class="banner banner-secondary" id="top" style="background-image: url(img/Quebrada-de-cafayate.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Novedades </h2>

                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class="form-group">
                    <img src=<?php echo (str_replace(' ', '%20', $novedadData["imagen"])); ?> class="img-responsive mx-auto img-novedad" alt="">
                </div>
                
                
                <div class="content-novedad">
                    <h2 class="text-center"><?php echo($novedadData["titulo"]); ?></h2>
                    <div class="fecha-novedad text-center"><h4><i class="fa fa-calendar"></i> <?php echo($novedadData["fecha"]); ?> </h4></div>

                    <div class="text-justify">
                        <?php echo($novedadData["contenido"]); ?>
                    </div>

                </div>
            </div>
        </section>
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