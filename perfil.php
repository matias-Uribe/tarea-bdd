<?php include("template/cabecera.php");


$query = $conexion->prepare("SELECT * FROM `usuario` WHERE nombreUsuario='$nombreUsuario';");
$query->execute();
$listaU = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $listaU[0]["fotoUsuario"];
$des = $listaU[0]["descripcion"];
$idU = $listaU[0]["idUsuario"];
$cantP = $listaU[0]["cantP"];


$seguidos = 0;
$seguidores = 0;
$txtaccion = (isset($_POST["accion"])) ? $_POST["accion"] : "";
switch ($txtaccion) {
  case 'Actualizar':
    header("location:modificar.php");
    break;

  case 'guardar':

    $foto = (isset($_FILES["txtImagen"]["name"])) ? $_FILES["txtImagen"]["name"] : "";
    $nombreUsuario = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $des = (isset($_POST["exampleTextarea"])) ? $_POST["exampleTextarea"] : "";
    $con = (isset($_POST["contraseña"])) ? $_POST["contraseña"] : "";
    $correo = (isset($_POST["correo"])) ? $_POST["correo"] : "";

    if ($foto == "") {
      $nombreArchivo = $FOTOUSUARIO;
    } else {
      if (isset($FOTOUSUARIO) && ($FOTOUSUARIO != "usuario.png")) {
        if (file_exists("img/" . $FOTOUSUARIO)) {
          unlink("img/" . $FOTOUSUARIO);
        }
      }
      $fecha = new DateTime();
      $nombreArchivo = ($foto != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "usuario.png";
      $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

      if ($tmpImagen != "") {
        move_uploaded_file($tmpImagen, "img/" . $nombreArchivo);
      }
    }



    $query = $conexion->prepare("UPDATE `usuario` SET `nombreUsuario`='$nombreUsuario', `fotoUsuario`='$nombreArchivo', `descripcion`='$des',`contraseña`='$con',`correo`='$correo'  WHERE idUsuario=$IDUSUARIO;");
    $query->execute();


    session_destroy();

    $query = $conexion->prepare("SELECT * FROM `usuario` WHERE nombreUsuario='$nombreUsuario';");
    $query->execute();
    $listaU = $query->fetchAll(PDO::FETCH_ASSOC);
    session_start();
    if ($_POST) {
      if ($con == $listaU[0]['contraseña']) {
        $_SESSION['usuario'] = "ok";
        $_SESSION['nombreUsuario'] = $nombreUsuario;
        header("location:perfil.php");
      }
    }

    break;

  case 'eliminar':

    if (isset($foto) && ($foto != "usuario.png")) {
      if (file_exists("img/" . $foto)) {
        unlink("img/" . $foto);
      }
    }



    $query = $conexion->prepare("delete from usuario where idUsuario=:id");
    $query->bindParam(':id', $IDUSUARIO);
    $query->execute();
    session_destroy();
    header("location:perfil.php");
    break;
  default:
    # code...
    break;
}
?>

<div class="col-md-3">
  <div class="card">
    <?php if (empty($foto)) { ?>
    <img class="card-img-top" src="img/usuario.png" height="280">
    <?php } else { ?>
    <img class="card-img-top" src="img/<?php echo $foto ?>" height="280">
    <?php } ?>
  </div>
  <br />
</div>


<div class="col-md-9">
  <div class="row">
    <div class="col-md-10">
      </br>
      </br>
      </br>
      <h2>Usuario : <strong>
          <?php echo $nombreUsuario ?>
        </strong></h2>
      <div class="card text-white bg-secondary mb-3" style="max-width: 50rem;">
        <div class="card-header">Descripcion:</div>
        <div class="card-body">
          <p class="card-text">
            <?php echo $des ?>
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <form method="POST">
        <input type="submit" name="accion" value="Actualizar" class="btn btn-lg btn-primary" />
      </form>
    </div>

  </div>
</div>


<?php

$query = $conexion->prepare("SELECT count(*) FROM `seguidos` WHERE idUsuario1='$IDUSUARIO';");
$query->execute();
$lista1 = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conexion->prepare("SELECT count(*) FROM `seguidos` WHERE idUsuario2='$IDUSUARIO';");
$query->execute();
$lista2 = $query->fetchAll(PDO::FETCH_ASSOC);



?>

<div class="row">
  <div class="col-md-5">
    <h3 style="text-align:center;">Numero de Seguidores:</h3>
    <form method="POST">
      <p style="text-align:center;"><button type="submit" name="accion" value="seguidores" class="btn btn-info">
          <h2>
            <?php echo $lista2[0]["count(*)"] ?>
          </h2>
        </button></p>
    </form>
    </br></br>
    <h3 style="text-align:center;">Numero de Peliculas Rentadas:</h3>
    <h1 style="text-align:center;"><strong>
        <?php echo $cantP ?>
      </strong></h1>

  </div>


  <div class="col-md-5">
    <h3 style="text-align:center;">Numero de Seguidos:</h3>
    <form method="POST">
      <p style="text-align:center;"><button type="submit" name="accion" value="seguidos" class="btn btn-info">
          <h2>
            <?php echo $lista1[0]["count(*)"] ?>
          </h2>
        </button></p>
      <p style="text-align:center;"><button type="submit" name="accion" value="listafav" class="btn btn-info">
          <h4>Lista Favoritas</h4>
        </button></p>
      <p style="text-align:center;"><button type="submit" name="accion" value="mispelis" class="btn btn-info">
          <h4>Mis Peliculas</h4>
        </button></p>
      <p style="text-align:center;"><button type="submit" name="accion" value="misrese" class="btn btn-info">
          <h4>Mis Reseñas</h4>
        </button></p>
    </form>
  </div>



</div>




<?php
$txtaccion = (isset($_POST["accion"])) ? $_POST["accion"] : "";
switch ($txtaccion) {
  case 'seguidores':
    include("template/seguidores.php");
    break;
  case 'seguidos':
    include("template/seguidos.php");
    break;
  case 'listafav':
    include("template/listafav.php");
    break;
  case 'mispelis':
    include("template/mispelis.php");
    break;
  case 'misrese':
    include("template/misrese.php");
    break;


  default:
    # code...
    break;
}
?>




</div>
</div>



<?php include("template/pie.php"); ?>