<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Proyecto Cafayate Comercios</title>

    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="css/fontAwesome.css" />
    <link rel="stylesheet" href="css/hero-slider.css" />
    <link rel="stylesheet" href="css/owl-carousel.css" />
    <link rel="stylesheet" href="css/style.css">

    <link
      href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900"
      rel="stylesheet"
    />

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
  </head>

  <body>
  <?php
include("config.php");

if( isset($_POST['submit'])) {
	$email = $_POST['email'];
	$pass = $_POST['password'];
  $id_rol = 1;
  $name = "test";
  $tel = "123";
  $apellido = "apellido";
  $dni = "321";

	if($email == "" || $pass == "") {
		echo "All fields should be filled. Either one or many fields are empty.";
		echo "<br/>";
		echo "<a href='register.php'>Go back</a>";
	} else {
		mysqli_query($conexion, "INSERT INTO usuarios(nombre, apellido, telefono, correo, password, dni, id_rol) VALUES('$name', '$apellido', '$tel', '$email', md5('$pass'), '$dni', '$id_rol')")
		or die($conexion->error);
			
		echo "Registration successfully";
		echo "<br/>";
		// echo "<a href='login.php'>Login</a>";
	}
} else {
?>
    <div class="wrap">
      <header id="header">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <button id="primary-nav-button" type="button">Menu</button>
              <a href="inicio.html"
                ><div class="logo">
                  <img src="img/logo2.png" alt="Venue Logo" /></div
              ></a>
              <nav id="primary-nav" class="dropdown cf">
                <ul class="dropdown menu">
                  <li><a href="inicio.html">Inicio</a></li>

                  <li class="active"><a href="comercios.html">Comercios</a></li>

                  <li><a href="novedades.html">Novedades</a></li>

                  <li><a href="turismo.html">Turismo</a></li>

                  <li><a href="turismo.html">Cuenta</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </header>
    </div>

    <section
      class="banner banner-secondary"
      id="top"
      style="background-image: url(img/banner-image-1-1920x3001.jpg)"
    >
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
              Registrarse
            </h3>
            
            <div class="main">
                <label for="email">Ingresa tu correo electronico</label>
                <input
                type="text"
                class="form-control"
                name="email"
                placeholder="Email"
                autofocus
                />
                <label for="password">Ingresa tu contraseña</label>
                <input
                type="password"
                class="form-control"
                name="password"
                placeholder="Password"
              />

              <p class="text-right" ><a href="#">Olvide mi contraseña</a></p>
              <span class="clearfix"></span>
            </div>
            <div class="login-footer">
              <div class="row">
                <div class="col-xs-6 col-md-6">
                  <!-- <div class="left-section">
                    <a href="">Forgot your password?</a>
                    <a href="">Sign up now</a>
                  </div> -->
                </div>
                <div class="col-xs-6 col-md-6 pull-right">
                  <button
                    type="submit"
                    name="submit"
                    class="orange btn btn-large pull-right"
                  >
                    Registrarse
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </main>

    <div class="sub-footer">
      <p>
        Copyright © 2022 Practica Profesionalizante II Di Benedetto - Barral
      </p>
    </div>

    <script
      src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"
      type="text/javascript"
    ></script>
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
