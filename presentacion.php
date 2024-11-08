<?php
include("bdd/conexion.php");

$txtaccion = (isset($_POST["accion"])) ? $_POST["accion"] : "";
$txtUs = (isset($_POST["usuario"])) ? $_POST["usuario"] : "";
$txtCon = (isset($_POST["contraseña"])) ? $_POST["contraseña"] : "";



switch ($txtaccion) {
    case 'Crear cuenta':
        header("location:crearcuenta.php");
        break;

    case 'Entrar':

        $query = $conexion->prepare("SELECT * FROM `usuario` WHERE nombreUsuario='$txtUs';");
        $query->execute();
        $listaU = $query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($txtUs) || empty($txtCon)) {
            $mensaje = "Error falto algun campo que rellenar";
            break;
        }

        if (empty($listaU)) {
            $mensaje = "Usuario o contraseña incorrectos";
            break;
        } else {
            session_start();
            if ($_POST) {
                if ($txtCon == $listaU[0]['contraseña']) {
                    $_SESSION['usuario'] = "ok";
                    $_SESSION['nombreUsuario'] = $txtUs;
                    header("location:index.php");
                } else {
                    $mensaje = "Error el usuario y contraseña son incorrectos";
                }
            }
        }
        break;

    default:
        break;
    //
//
    //   session_start();
    //   if($_POST){
    //   if(($_POST['usuario']=="maty")&&($_POST['contraseña']=="123")){
    //       $_SESSION['usuario']="ok";
    //       $_SESSION['nombreUsuario']="maty";
    //       header("location:index.php");
    //   }else{
    //       $mensaje="Error el usuario y contraseña son incorrectos";
    //   }
    //   }
    //       break;


}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="shortcut icon" href="img/logo.png">
    <title>Blockbusm</title>
    <meta charset="utf-8">
</head>




<body>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <br /><br />
                <div class="jumbotron">
                    <img class="card-img-right" src="img/logo.png" alt="" height="180" href="perfil.php">
                    <h1 class="display-3">Sean bienvenidos a Blockbusm</h1>
                    <p class="lead">Blockbusm es una experiencia nueva y unica de poder arrendar tus peliculas favorias
                    </p>
                    <hr class="my-2">
                </div>



            </div>
            <div class="col-md-3">
                <br /><br /><br />
                <?php include("template/login.php") ?>

                <input type="submit" name="accion" value="Crear cuenta" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

</html>