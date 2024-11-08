<?php
include("bdd/conexion.php");
$txtaccion=(isset($_POST["accion"]))?$_POST["accion"]:"";
$txtU=(isset($_POST["txtU"]))?$_POST["txtU"]:"";
$txtC=(isset($_POST["txtC"]))?$_POST["txtC"]:"";
$txtCo=(isset($_POST["txtCo"]))?$_POST["txtCo"]:"";
echo $txtaccion;

switch ($txtaccion) {
    case 'agregar':
        $query=$conexion->prepare("SELECT * FROM `usuario` WHERE nombreUsuario='$txtU';");
        $query->execute();
        $listaU=$query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($txtU)||empty($txtC)||empty($txtCo)) {
            $mensaje="Error falto algun campo que rellenar";
            break;
        }
        if (empty($listaU)) {

            $query=$conexion->prepare("INSERT INTO `usuario` (`nombreUsuario`,`contraseña`,`correo`,`dinero`) VALUES (:us, :con, :cor, 200000);");
            $query->bindParam(':us',$txtU);
            $query->bindParam(':con',$txtC);
            $query->bindParam(':cor',$txtCo);
            $query->execute();  
            header("location:index.php");
        }
        else {
            $mensaje="Ya existe este usuario";
            break;
        }


        break;
    case 'cancelar':
        header("location:presentacion.php");
    default:

        break;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <title>administrador</title>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <meta charset="utf-8">
    </head>




    <body>
    <div class="container">
    <div class="row">
    <div class="col-md-3">

    </div>

    <div class="col-md-6">
    </br>
<div class="card">
    <div class="card-header">
        Crea cuenta
    </div>

    <div class="card-body">
    <?php if (isset($mensaje)) {?>
                                    <div class="alert alert-danger" role="alert">
                                    <?php echo $mensaje;?>
                                    </div>   
                                <?php }?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <label for="txtCo" >Correo</label>
        <input type="text" class="form-control" name ="txtCo" id="txtCo" placeholder="ingrese su correo">
        </div>
        <div class="form-group">
        <label for="txtU" >Usuario</label>
        <input type="text" class="form-control" name ="txtU" id="txtU" placeholder="Usuario">
        </div>
        <div class="form-group">
        <label for="txtC" >Contraseña</label>
        <input type="password" class="form-control" name ="txtC" id="txtC" placeholder="Contraseña">
        </div>
</br>
<div class="btn-group" role="group" aria-label="">
            <button type="submit" name="accion" value="agregar" class="btn btn-success">Crear</button>
            <button type="submit" name="accion" value="cancelar" class="btn btn-danger">Cancelar</button>
        </div>
    </form>



    </div>
</div>
</div>
</div>
</div>


    </body>
</html>