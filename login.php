<?php
//logica de conexion al administrador

include("config/conexionBD.php");


if($conexion){
  echo "conectada";
}else{
  echo "No Conectada";
}



session_start();

$sentenciaSQL= $conexion->prepare("SELECT * FROM usuarios");
$sentenciaSQL->execute();
$listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);//con esta fetch  almaceno todos los usuarios en una lista, para luego llenar la tabla

if($_POST){//si hay un post (o sea si presionan el boton ingresar con todos los campos llenos)

  foreach($listaUsuarios as $usuario){
    
    if(($_POST['usuario']==$usuario['usuario']) && ($_POST['contrasenia']==$usuario['contrasenia'])){


      $_SESSION['usuario']="ok";
      $_SESSION['nombreUsuario']=$usuario['usuario'];
      header("Location:administrador.php");

      break;//lo freno por si las moscas jajaj creo que cunado lo redireccina al inicio.php se sale automaticamente de aqui, pero no se 

    }else{
      $mensaje="Usuario o contraseña incorrectos";
    } 

    
  } 

}



////bueno


?>





<?php include("template/cabecera.php"); ?>




<style>



    .contenedor{

        display: flex;
        /*background-color: rgba(0, 0, 0, 0.305);/**/
        align-items: center;
        justify-content: center;/**/
        
        margin-top: 50px;
        margin-bottom: 150px;

    }


    .caja{
        color: white;
        background-color: rgba(0, 0, 0, 0.150);
        padding: 20px 20px 20px 20px;
        border-radius: 15px;
       /* box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.39), 0 0 10px 4px rgba(45, 45, 45, 0.455);/** */

    }


    input{
        border-radius: 5px;/**/
        margin-top: 7px;
        margin-bottom: 25px;
        /*background-color: transparent;/**/
        border-color: transparent;
        outline: 2px solid #088cff;
        background-color: rgba(0, 0, 0, 0.53);
        color: white;
    }

    input:hover{
        box-shadow: 0 0 10px 0 rgba(53, 99, 144, 0.39), 0 0 10px 4px rgba(53, 99, 144, 0.455);        
    }

    .textMensaje{
        color: gray;
        font-size: 0.7rem;
    }


    .boton{
        background-color: rgb(0, 102, 255);/**/
        color: rgb(255, 255, 255);
        border-radius: 10px;
        padding: 5px 50px 5px 50px;
        border-color: transparent;
        margin-left: 12px;      
    }


</style>



  


<div class="contenedor">


    <div class="caja">

        <h1>Login</h1>
        <br>

        <form method="POST" >

            <p>
            <input type="text" name="usuario" id="namePadre" placeholder ="Ingrese el usuario"  autocomplete required> 
            </p>

            <p>
            <input type="password" name="contrasenia" id="passwd" placeholder="Ingrese la contraseña"  required/>
            </p>

            <div>
            
            <?php if(isset($mensaje)){ ?>
                <p class="textMensaje"><?php echo $mensaje; ?></p>
            <?php } ?>

            </div>

            
            <br>
            <input type="submit" value="Ingresar" class="boton">

        </form>

        <br>

    </div>

</div>





<?php include("template/pie.php"); ?>