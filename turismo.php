<?php
include_once("./utils/sessions.php");
include_once("./db/main.php");
$pdata = $db_base->query("SELECT * FROM datos_publicos LIMIT 1");
$info = mysqli_fetch_assoc($pdata[1]);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Turismo</title>
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
                        <h2>Turismo</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="our-services">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="left-content">
                            <p><?php echo $info["bienvenida_turismo"] ?></p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img src="img/about-1-720x4802.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section id="video-container">
            <div class="video-overlay"></div>
            <div class="video-content">
                <div class="inner">
                    <div class="section-heading">
                        <span>Lorem ipsum dolor.</span>
                        <h2>Vivamus nec vehicula felis</h2>
                    </div>
                    <!-- Modal button -->

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-lg-offset-1">
                                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi blanditiis, esse deserunt assumenda! Tempora nulla natus illum soluta quasi, nisi, in quaerat cumque corrupti ipsum impedit necessitatibus expedita minus harum, fuga id aperiam autem architecto odio. Perferendis eius possimus ex itaque tenetur saepe id quis dicta voluptas, corrupti sapiente hic!</p>
                            </div>
                        </div>
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