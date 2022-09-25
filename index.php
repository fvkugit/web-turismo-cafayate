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
        <title>Proyecto Cafayate - Inicio</title>
        <?php include_once 'header.php'; ?>
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
                                    <a href="./vernovedad.php?id=<?php echo ($noticia["id_novedad"]); ?>">Leer más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </section>



    <?php include_once("./footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="js/vendor/bootstrap.min.js"></script>
    
    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>
</html>