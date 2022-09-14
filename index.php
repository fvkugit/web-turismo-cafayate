<?php
include_once("./utils/sessions.php");
include_once("./db/main.php");
$pdata = $db_base->query("SELECT * FROM datos_publicos LIMIT 1");
$ndata = $db_base->query("SELECT * FROM novedades LIMIT 3");
$info = mysqli_fetch_assoc($pdata[1]);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Proyecto Cafayate Inicio</title>
        
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
      
    <section class="banner" id="top" style="background-image: url(img/Quebrada-de-cafayate.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Ciudad de Cafayate, un paraíso por explorar</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="our-services">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <p><?php echo $info["bienvenida"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <span>Últimas Novedades</span>
                            <h2>Enterate de las noticias en su apartado.</h2>
                        </div>
                    </div> 
                </div> 
                <div class="row">
                    <?php while($noticia = mysqli_fetch_assoc($ndata[1])){ ?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src=<?php echo $noticia["imagen"]?> alt="">
                                </div>
                            </div>

                            <div class="down-content">
                                <h4><?php echo $noticia["titulo"] ?></h4>

                                <p><?php echo $noticia["contenido"] ?></p>

                                <div class="text-button">
                                    <a href="novevades-detalles.html">Leer Mas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </section>



        <div class="sub-footer">
            <p>Copyright © 2022 Practica Profesionalizante II Di Benedetto - Barral</p>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="js/vendor/bootstrap.min.js"></script>
    
    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>
</html>