<?php include("template/cabecera.php"); ?>




<?php

include("config/conexionBD.php");

/**  /////////////////////  esto pertenece al registro de ingresos ////////////////////////// */

    $Object = new DateTime();
    $Object->setTimezone(new DateTimeZone('America/Costa_Rica'));
    $fechaYhoraHistorial = $Object->format("d-m-Y h:i:s a"); 
    
    $ip="";
    $procendenteDePagina ="";
    $agenteUsuario = "";


    $ip = $_SERVER['REMOTE_ADDR'];
    $procendenteDePagina = $_SERVER['HTTP_REFERER'];
    $agenteUsuario = $_SERVER['HTTP_USER_AGENT'];

    //envio de datos para el historial
    $sentenciaSQL = $conexion->prepare("INSERT INTO historialingresos (fechaYhoraHistorial,ip,procendenteDePagina,agenteUsuario) VALUES (:fechaYhoraHistorial,:ip,:procendenteDePagina,:agenteUsuario);");
    $sentenciaSQL->bindParam(':fechaYhoraHistorial',$fechaYhoraHistorial);
    $sentenciaSQL->bindParam(':ip',$ip);
    $sentenciaSQL->bindParam(':procendenteDePagina',$procendenteDePagina);
    $sentenciaSQL->bindParam(':agenteUsuario',$agenteUsuario);
    $sentenciaSQL->execute();

/**  ///////////////////// FIN DE  esto pertenece al registro de ingresos ////////////////////////// */


$ubicacion =(isset($_POST['ubicacion']))?$_POST['ubicacion']:"";

$mensaje =(isset($_POST['mensaje']))?$_POST['mensaje']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";



switch($accion){

  case"Enviar":

    $Object = new DateTime();
    $Object->setTimezone(new DateTimeZone('America/Costa_Rica'));
    $fechaYhora = $Object->format("d-m-Y h:i:s a");  

    $ip= $_SERVER['REMOTE_ADDR'];
    $agenteUsuario = $_SERVER['HTTP_USER_AGENT'];

    //Envio de datos si presino el boton registar
    $sentenciaSQL = $conexion->prepare("INSERT INTO mensajesanonimos (mensaje,fechaYhora,ip,agenteUsuario) VALUES (:mensaje,:fechaYhora,:ip,:agenteUsuario);");
    $sentenciaSQL->bindParam(':mensaje',$mensaje);
    $sentenciaSQL->bindParam(':fechaYhora',$fechaYhora);
    $sentenciaSQL->bindParam(':ip',$ip);
    $sentenciaSQL->bindParam(':agenteUsuario',$agenteUsuario);
    $sentenciaSQL->execute();



    /** //////////////    Aqui voy a hacer que me envie un correo a mi correo cunado se envia un mensaje ////////////*/

    // MI hosting es gratuito y no me deja enviar correos sendEmailPhp, tengo que pagar para eso, entonces voy a dejar este codigo por gurdado por aqui
    /*
    $header= "From : noreply@example.com" . "\r\n";
    $header.= "Reply-To: noreply@example.com" . "\r\n";
    $header.= "X-Mailer: PHP/". phpversion();
    $mail = mail("alejandrovc177@gmail.com",$ip,$mensaje, $header);
    if($mail){
        echo "Comprobante enviado al correo";
    }
    */

    /** //////////////    Aqui voy a hacer que me envie un correo a mi correo cunado se envia un mensaje ////////////*/



    //limpio los campos una vez que los registre
    $mensaje ="";
    

  break;

}


$sentenciaSQL= $conexion->prepare("SELECT * FROM mensajesanonimos");
$sentenciaSQL->execute();
$listaMensajes=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);//con esta fetch  almaceno todos los bovino en una lista, para luego llenar la tabla


?>






<div class="titulo">
    <h1>Vale la pena volver a empezar una y mil veces más mientras uno esté vivo</h1>
    <h2>Este es el mensaje más grande de la vida que se puede resumir en <br> "Derrotados son los que dejan de luchar y dejar de luchar es dejar de soñar".</h2> 
</div>

<div class="ingresarMensaje">

    <form method="POST">

        <div class="input-group">
            <textarea type="textarea"  value="<?php echo $mensaje ?>" class="textarea" id="mensaje" name="mensaje" rows="4" cols="50"   placeholder ="Escribe un mensaje anónimo"  required ></textarea>
        </div>    
            
        <input   type="submit" name="accion" value="Enviar" class="button"  onclick="getLocation()">
        
    </form>

</div>


<div class="contenedorPadreMensajes">

    <div class="contnedorListaMensajes">

        <h4 class="cantidadMensajesTitle">📩 Mensajes anónimos <?php echo sizeof($listaMensajes);?></h4>


        <div class="listaMensajes">

            <?php  for ($i = sizeof($listaMensajes)-1; $i > -1 ; $i--){ ?>

                <div class="mensaje">
                    <p class="hora"><?php echo $listaMensajes[$i]['fechaYhora']; ?></p>
                    <br>
                    <p><?php echo $listaMensajes[$i]['mensaje']; ?></p>
                </div>

            <?php } ?>

        </div>

    </div>

</div>





                 

<?php include("template/pie.php"); ?>