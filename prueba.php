<?php

include("bdd/conexion.php");
session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location:presentacion.php");
    }else{
        if($_SESSION['usuario']=="ok"){
            $nombreUsuario=$_SESSION["nombreUsuario"];
        }
    }

    $query=$conexion->prepare("SELECT * FROM `usuario` WHERE nombreUsuario='$nombreUsuario';");
    $query->execute();
    $listaU=$query->fetchAll(PDO::FETCH_ASSOC);
    $dinero=$listaU[0]["dinero"];
    $IDUSUARIO=$listaU[0]["idUsuario"];
    $FOTOUSUARIO=$listaU[0]["fotoUsuario"];


$id=(isset($_POST["eleccion"]))?$_POST["eleccion"]:"";
if (!empty((isset($_POST["arrendar"]))?$_POST["arrendar"]:"")) {
  $id=(isset($_POST["arrendar"]))?$_POST["arrendar"]:"";
  $query=$conexion->prepare("INSERT INTO `rentadas` (`idPelicula`,`idUsuario`) VALUES (:p, :u);");
  $query->bindParam(':p',$id);
  $query->bindParam(':u',$IDUSUARIO);
  $query->execute();
  $query=$conexion->prepare("SELECT * FROM `pelicula` WHERE idPelicula='$id';");
  $query->execute();
  $Precio=$query->fetchAll(PDO::FETCH_ASSOC);
  $pp=$Precio[0]["precio"];
  $dinero=$dinero-$pp;
  $query=$conexion->prepare("UPDATE `usuario` SET `dinero`='$dinero' WHERE idUsuario='$IDUSUARIO';");
  $query->execute();
  
}

if (!empty((isset($_POST["devolver"]))?$_POST["devolver"]:"")) {
  $id=(isset($_POST["devolver"]))?$_POST["devolver"]:"";
  $query=$conexion->prepare("DELETE FROM `rentadas` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO';");
  $query->execute();
}

if (!empty((isset($_POST["agregar"]))?$_POST["agregar"]:"")) {
  $id=(isset($_POST["agregar"]))?$_POST["agregar"]:"";
  $query=$conexion->prepare("INSERT INTO `favoritas` (`idPelicula`,`idUsuario`) VALUES (:p, :u);");
  $query->bindParam(':p',$id);
  $query->bindParam(':u',$IDUSUARIO);
  $query->execute();
}

if (!empty((isset($_POST["eliminar"]))?$_POST["eliminar"]:"")) {
  $id=(isset($_POST["eliminar"]))?$_POST["eliminar"]:"";
  $query=$conexion->prepare("DELETE FROM `favoritas` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO';");
  $query->execute();
}

if (!empty((isset($_POST["guardar"]))?$_POST["guardar"]:"")) {
  $id=(isset($_POST["guardar"]))?$_POST["guardar"]:"";
  $DES=(isset($_POST["exampleTextarea"]))?$_POST["exampleTextarea"]:"";
  $CAL=(isset($_POST["exampleSelect1"]))?$_POST["exampleSelect1"]:"";
  $query=$conexion->prepare("SELECT * FROM `reseña` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO';");
  $query->execute();
  $R=$query->fetchAll(PDO::FETCH_ASSOC);

  if (!empty($R[0]["idPelicula"])) {
    $query=$conexion->prepare("UPDATE `reseña` SET `descripcionReseña`='$DES', `puntuacion`='$CAL'  WHERE idUsuario=$IDUSUARIO and idPelicula=$id;");
    $query->execute();
  }
  else {
    $f=date('Y-m-d');
    $query=$conexion->prepare("INSERT INTO `reseña` (`idUsuario`,`descripcionReseña`,`idPelicula`,`fecha`,`puntuacion`) VALUES (:u,:d,:p,:f,:c);");
    $query->bindParam(':u',$IDUSUARIO);
    $query->bindParam(':d',$DES);
    $query->bindParam(':p',$id);
    $query->bindParam(':f',$f);
    $query->bindParam(':c',$CAL);
    
    $query->execute();
  }
}

if (!empty((isset($_POST["eliminar2"]))?$_POST["eliminar2"]:"")) {
  $id=(isset($_POST["eliminar2"]))?$_POST["eliminar2"]:"";
  $query=$conexion->prepare("DELETE FROM `reseña` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO';");
  $query->execute();
}








  include("template/cabecera2.php");
    $query=$conexion->prepare("SELECT * FROM `pelicula` WHERE idPelicula='$id';");
    $query->execute();
    $listaP=$query->fetchAll(PDO::FETCH_ASSOC);
    $pn =$listaP[0]["nombrePelicula"];
    $pdu= $listaP[0]["duracion"];
    $pde= $listaP[0]["descripcion"];
    $pu =$listaP[0]["publico"];
    $ps =$listaP[0]["stock"];
    $pr =$listaP[0]["rentadas"];
    $pf =$listaP[0]["fotoPelicula"];
    $pp =$listaP[0]["precio"];

?>

<div class="col-md-3">
    <div class="card">
      <?php if (empty($pf)) {?>
        <img class="card-img-top" src="img/usuario.png" height="350">
      <?php }
      else { ?>
        <img class="card-img-top" src="img/<?php echo $pf ?>"  height="350">
      <?php } ?>
    </div>
    <br/>    
</div> 


<div class="col-md-9">
<h1 style="text-align:center;"><strong><?php echo $pn?></strong></h1>
  <div class="row">
    <div class="col-md-6">
      </br>
      </br>
      </br>     
      <h2>Duracion: <strong><?php echo $pdu?></strong></h2>
      <h2>Publico : <strong><?php echo $pu?></strong></h2>
      <h2>Rentadas : <strong><?php echo $pr?></strong></h2>
      </br>
      </br>
      </br>
    </div>

    <div class="col-md-4">
      </br>
      </br>
      </br>     
      <h2>Puntuacion : <strong>calcular</strong></h2>
      <h2>Disponibles : <strong>calcular</strong></h2>
      <h2>Stock : <strong><?php echo $ps?></strong></h2>
      </br>
      </br>    
      </br>
      </br>
    </div>

    <div class="col-md-2">
        </br>
        <button type="button" class="btn btn-primary"><a href="peliculas.php" style="color:#ffffff">Volver</a></button>
        </br>
        </br>

        <?php
        $query=$conexion->prepare("SELECT * FROM `rentadas` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO';");
        $query->execute();
        $r=$query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($r[0]["idPelicula"])) { ?>
          <form method="POST" ACTION="mostrarpeli.php">
          <button type="submit" name="arrendar" value="<?php echo $id ?>" class="btn btn-lg btn-primary">Arrendar</button>
          </form>
          </br> 
        <?php } 
        else { ?>
          <form method="POST" ACTION="mostrarpeli.php">
          <button type="submit" name="devolver" value="<?php echo $id ?>" class="btn btn-lg btn-primary">Devolver</button>
          </form>
          </br> 
        <?php } 

   
        $query=$conexion->prepare("SELECT * FROM `favoritas` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO';");
        $query->execute();
        $r2=$query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($r2[0]["idPelicula"])) { ?>
          <form method="POST" ACTION="mostrarpeli.php">
          <button type="submit" name="agregar" value="<?php echo $id ?>" class="btn btn-lg btn-primary">Agregar a Favoritas</button>
          </form>
          </br> 
        <?php } 
        else { ?>
          <form method="POST" ACTION="mostrarpeli.php">
          <button type="submit" name="eliminar" value="<?php echo $id ?>" class="btn btn-lg btn-primary">Eliminar de Favoritas</button>
          </form>
          </br> 
        <?php } ?>







    </div>

  </div>    
</div>

 
<div class="card text-white bg-secondary mb-3" style="max-width: 80rem;">
    <div class="card-header">Descripcion:</div>
    <div class="card-body">
        <p class="card-text"><?php echo $pde ?></p>
    </div>
    <form method="POST" ACTION="cmreseña.php">
    <button type="submit" name="reseña" value="<?php echo $id ?>" class="btn btn-lg btn-primary">MI RESEÑA</button>
    </form>
</div>



<?php
    $query=$conexion->prepare("SELECT * FROM `reseña` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO' ;");
    $query->execute();
    $listaP=$query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($listaP)) {?>

<div class="card text-white bg-secondary mb-3" style="max-width: 80rem;">
  <div class="row">
  <div class="col-md-2">
     <div class="card-body">
     <img class="card-img-top" src="img/<?php echo $FOTOUSUARIO; ?>"  height="150">
     </div>
    </div>
    <div class="col-md-10">
    <div class="row">
        <div class="col-md-1">
            Nombre
            <?php echo $nombreUsuario;?>
        </div>
        <div class="col-md-2">
            Fecha</br>
            <?php echo $listaP[0]["fecha"];?>
        </div>
        <div class="col-md-2">
            Puntuacion:
            <strong><?php echo $listaP[0]["puntuacion"];?></strong> 
        </div>
        <div class="col-md-5">
        </div>
        <div class="col-md-1">
        </div>

    </div>
     <div class="card-body">
       <p class="card-text"><?php echo $listaP[0]["descripcionReseña"];?></p>
     </div>
</div>

<?php }
   
   $query=$conexion->prepare("SELECT * FROM reseña WHERE idPelicula='$id' and idUsuario!='$IDUSUARIO' ORDER BY fecha DESC LIMIT 5;");
   $query->execute();
   $listaP=$query->fetchAll(PDO::FETCH_ASSOC);
   foreach($listaP as $reseñas){
        $x=$reseñas["idUsuario"];
        $query2=$conexion->prepare("SELECT * FROM usuario WHERE idUsuario='$x';");
        $query2->execute();
        $Usuarios=$query2->fetchAll(PDO::FETCH_ASSOC);
   
?>
<div class="card text-white bg-secondary mb-3" style="max-width: 80rem;">
  <div class="row">
  <div class="col-md-2">
     <div class="card-body">
     <form method="POST" ACTION="otroperfil.php">
    <button type="submit" name="eleccion" value="<?php echo $Usuarios[0]["idUsuario"]?>" class="btn btn-secondary">
    <img class="card-img-top" src="img/<?php echo $Usuarios[0]["fotoUsuario"]; ?>"  height="150">
        </button>
</form>
     </div>
    </div>
    <div class="col-md-10">
    <div class="row">
        <div class="col-md-1">
            Nombre
            <?php echo $Usuarios[0]["nombreUsuario"];?>
        </div>
        <div class="col-md-2">
            Fecha</br>
            <?php echo $reseñas["fecha"];?>
        </div>
        <div class="col-md-2">
            Puntuacion:
            <strong><?php echo $reseñas["puntuacion"];?></strong>
            
        </div>
    </div>
     <div class="card-body">
       <p class="card-text"><?php echo $reseñas["descripcionReseña"];?></p>
     </div>
</div>





<?php }?>


   
<?php include("template/pie.php") ?>