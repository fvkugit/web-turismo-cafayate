<?php

include_once("./utils/sessions.php");
include_once("./db/main.php");
$listComercios = $comercios->obtenerTodo();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Proyecto Cafayate - Comercios</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>

    <?php include_once 'navbar.php'; ?>

    <section class="banner banner-secondary" id="top" style="background-image: url(img/banner-image-1-1920x3001.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Comercios</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <?php while ($comercio = mysqli_fetch_assoc($listComercios)) { ?>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="featured-item">
                                <div class="thumb">
                                    <div class="thumb-img">
                                        <img class="imagen-grilla mb-4" src=<?php echo($comercio["url"]); ?> alt="">
                                    </div>


                                </div>

                                <div class="down-content">
                                    <h4><?php echo($comercio["nombre"]); ?></h4>

                                    <?php echo(substr($comercio["descripcion"], 0, 170) . "<p> [...]</p>"); ?>

                                    <div class="text-button">
                                        <a href="vercomercio.php?id=<?php echo($comercio["id_comercio"]); ?>">Mas Información</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>




                </div>
            </div>
        </section>
    </main>

    <?php include_once("./footer.php"); ?>


    <div class="sub-footer">
        <p>Copyright © 2022 Practica Profesionalizante II Di Benedetto - Barral</p>
    </div>

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