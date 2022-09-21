<?php
include_once("./utils/sessions.php");
include_once("./db/main.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyecto Cafayate - Ingresar</title>
    <?php include_once 'header.php'; ?>
</head>

<body>
    <?php
    if (($_SERVER['REQUEST_METHOD'] === "POST") and (isset($_POST['login']))) {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $res = $usuarios->login(["correo" => "'$email'", "password" => "$pass"]);
        unset($_POST['login']);
        if ($res[0]) {
            $userdata = $res[1];
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $userdata['correo'];
            $_SESSION['id'] = $userdata['id_usuario'];
            $_SESSION['rol'] = $userdata['rol'];
            $message = "Iniciaste sesión correctamente.";
            require("result.php");
        } else {
            $error = "Los datos de inicio no son correctos.";
            require("ingresar.php");
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
                            <h2>Cuenta</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main>
            <div class="container">
                <div class="row">
                    <form method="POST" class="form-signin mg-btm mx-auto">
                        <h3 class="heading-desc">
                            Bienvenido nuevamente
                        </h3>
                        <?php if (isset($error)) { ?>
                            <h3 class="heading-desc text-red">
                                <?php echo ($error) ?>
                            </h3>
                        <?php } ?>

                        <div class="main">
                            <label for="email">Ingresa tu correo electronico</label>
                            <input type="text" class="form-control" placeholder="Email" name="email" autofocus />
                            <label for="password">Ingresa tu contraseña</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" />

                            <p class="text-right"><a href="#">Olvide mi contraseña</a></p>
                            <span class="clearfix"></span>
                        </div>
                        <div class="login-footer">
                            <div class="row">

                                <div class="col-xs-6 col-md-6 pull-right">
                                    <button type="submit" name="login" class="orange btn btn-large pull-right">
                                        Ingresar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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