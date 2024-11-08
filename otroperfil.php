<?php
include("template/cabecera.php");

$id = (isset($_POST["eleccion"])) ? $_POST["eleccion"] : "";
$flag = 0;
if (!empty((isset($_POST["seguir"])) ? $_POST["seguir"] : "")) {
  $id = (isset($_POST["seguir"])) ? $_POST["seguir"] : "";
  $query = $conexion->prepare("INSERT INTO `seguidos` (`idUsuario1`,`idUsuario2`) VALUES (:p, :u);");
  $query->bindParam(':p', $IDUSUARIO);
  $query->bindParam(':u', $id);
  $query->execute();
}

if (!empty((isset($_POST["Dseguir"])) ? $_POST["Dseguir"] : "")) {
  $id = (isset($_POST["Dseguir"])) ? $_POST["Dseguir"] : "";
  $query = $conexion->prepare("DELETE FROM `seguidos` WHERE idUsuario1='$IDUSUARIO' and idUsuario2='$id';");
  $query->execute();
}

if (!empty((isset($_POST["seguidore"])) ? $_POST["seguidore"] : "")) {
  $id = (isset($_POST["seguidore"])) ? $_POST["seguidore"] : "";
  $flag = 2;

}


if (!empty((isset($_POST["seguidos"])) ? $_POST["seguidos"] : "")) {
  $id = (isset($_POST["seguidos"])) ? $_POST["seguidos"] : "";
  $flag = 1;

}

if (!empty((isset($_POST["reseñas"])) ? $_POST["reseñas"] : "")) {
  $id = (isset($_POST["reseñas"])) ? $_POST["reseñas"] : "";
  $flag = 3;

}

if ($id == $IDUSUARIO) {
  header("location:perfil.php");
}

$query = $conexion->prepare("SELECT * FROM `usuario` WHERE idUsuario='$id';");
$query->execute();
$listaU = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $listaU[0]["fotoUsuario"];
$des = $listaU[0]["descripcion"];
$idN = $listaU[0]["nombreUsuario"];
$cantP = $listaU[0]["cantP"];
$seguidos = 0;
$seguidores = 0;





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
          <?php echo $idN ?>
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
    <?php

    $query = $conexion->prepare("SELECT * FROM  `seguidos` WHERE idUsuario1='$IDUSUARIO' and idUsuario2='$id';");
    $query->execute();
    $S = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($S[0]["idUsuario1"])) { ?>
    <div class="col-md-2">
      <form method="POST" ACTION="otroperfil.php">
        <button type="submit" name="seguir" value="<?php echo $id ?>" class="btn btn-lg btn-primary">Seguir</button>
      </form>
    </div>
    <?php } else { ?>
    <div class="col-md-2">
      <form method="POST" ACTION="otroperfil.php">
        <button type="submit" name="Dseguir" value="<?php echo $id ?>" class="btn btn-lg btn-primary">Dejar de
          seguir</button>
      </form>
    </div>
    <?php }

    ?>




  </div>
</div>


<div class="row">
  <div class="col-md-5">



    <?php

  $query = $conexion->prepare("SELECT count(*) FROM `seguidos` WHERE idUsuario1='$id';");
  $query->execute();
  $lista1 = $query->fetchAll(PDO::FETCH_ASSOC);

  $query = $conexion->prepare("SELECT count(*) FROM `seguidos` WHERE idUsuario2='$id';");
  $query->execute();
  $lista2 = $query->fetchAll(PDO::FETCH_ASSOC);



  ?>
    <h3 style="text-align:center;">Numero de Seguidores:</h3>
    <form method="POST" ACTION="otroperfil.php">
      <p style="text-align:center;"><button type="submit" name="seguidore" value="<?php echo $id ?>"
          class="btn btn-info">
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
      <p style="text-align:center;"><button type="submit" name="seguidos" value="<?php echo $id ?>"
          class="btn btn-info">
          <h2>
            <?php echo $lista1[0]["count(*)"] ?>
          </h2>
        </button></p>
      <p style="text-align:center;"><button type="submit" name="reseñas" value="<?php echo $id ?>" class="btn btn-info">
          <h4>Sus Reseñas</h4>
        </button></p>
    </form>
  </div>





  <?php

  if ($flag == 1) {
    $query = $conexion->prepare("SELECT idUsuario2 FROM `seguidos` WHERE idUsuario1='$id';");
    $query->execute();
    $listaSeguidos = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($listaSeguidos[0]["idUsuario2"])) {
      foreach ($listaSeguidos as $dato) {
        $us = $dato["idUsuario2"];
        $query = $conexion->prepare("SELECT * FROM `usuario` WHERE idUsuario='$us';");
        $query->execute();
        $lista = $query->fetchAll(PDO::FETCH_ASSOC);
        $T = $lista[0]["nombreUsuario"];
        $I = $lista[0]["fotoUsuario"];
        $D = $lista[0]["descripcion"];
        $C = $us;
        include("template/reseP.php");

      }
    }
  } elseif ($flag == 2) {
    $query = $conexion->prepare("SELECT idUsuario1 FROM `seguidos` WHERE idUsuario2='$id';");
    $query->execute();
    $listaSeguidos = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($listaSeguidos[0]["idUsuario1"])) {
      foreach ($listaSeguidos as $dato) {
        $us = $dato["idUsuario1"];
        $query = $conexion->prepare("SELECT * FROM `usuario` WHERE idUsuario='$us';");
        $query->execute();
        $lista = $query->fetchAll(PDO::FETCH_ASSOC);
        $T = $lista[0]["nombreUsuario"];
        $I = $lista[0]["fotoUsuario"];
        $D = $lista[0]["descripcion"];
        $C = $us;
        include("template/reseP.php");

      }
    }
  } elseif ($flag == 3) {
    $query = $conexion->prepare("SELECT * FROM `reseña` WHERE idUsuario='$id';");
    $query->execute();
    $listaSeguidos = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($listaSeguidos[0]["idUsuario"])) {
      $ud = $listaSeguidos[0]["idPelicula"];
      foreach ($listaSeguidos as $dato) {
        $query = $conexion->prepare("SELECT * FROM `pelicula` WHERE idPelicula='$ud';");
        $query->execute();
        $lista = $query->fetchAll(PDO::FETCH_ASSOC);
        $T = $lista[0]["nombrePelicula"];
        $I = $lista[0]["fotoPelicula"];
        $D = $dato["descripcionReseña"];
        $C = $ud;
        include("template/reseña.php");
      }
    }

  }



  ?>





</div>

























<?php
include("template/pie.php");
?>