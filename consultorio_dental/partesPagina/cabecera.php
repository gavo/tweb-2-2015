<?php
    include("utils/funciones.php");
?>
<!DOCTYPE html>
<head>
	<meta http-equiv = 'Content-Type' 	content = 'text/html; charset=utf-8'>
  	<meta name="Author" content="Gimena Burneett">
  	<meta name="Keywords" content="javascript, html">
  	<meta name="Description" content="Proyecto Final Tecnología Web">
    <link rel = 'shortcut icon' href = 'img/icon.gif'> 
  	<link href="estilo.css" rel="stylesheet" type="text/css">
    <script type='text/javascript' src='js/jquery-1.8.0.min.js'></script>
    <script type='text/javascript' src='js/functions.js'></script>
    <title>Consultorio Dental</title>
</head>
<body>
    <header>
        <img src="img/logo.png">
    </header>
    <nav>  
        <a href="index.php"><b>Inicio</b></a>
        <?php  
if(isset($_SESSION['user']) && isset($_SESSION['rango']) && isset($_SESSION['id'])){
     if($_SESSION['rango']>0){
        ?>
        <a href="usuario.php"><b>Gestionar Usuarios</b></a>
        <?php if($_SESSION['rango']==1){?>
        <a href="cita.php"><b>Atender Citas</b></a>
        <?php 
        }
    }else{?>        
        <a href="cita.php"><b>Solicitar Cita</b></a>
        <?php 
    }?> 
        <a href="#" onClick="mostrarOcultarOpcionesUsuario()"><b>Usuario <?php echo $_SESSION['user']?></b></a>
        <div id="opcionesUsuario">
            <a href="modificarusuario.php"><b>Editar Cuenta</b></a>
            <a href="salir.php" onClick="return permitirSalida()"><b>Salir</b></a>
        </div>
        <?php          
}else{
        ?>
        <a href="#" onClick="mostrarOcultarLogin()"><b>Iniciar Sesion</b></a>
        <form method='post' action='login.php' onSubmit="return validar_login()" id='login'>
                Usuario<br>
             <input title='Necesita Ingresar un Nombre de Usuario' type='text' name='user' id='login-name' required='true'><br>
                Contraseña<br>
             <input title='Necesita Ingresar una contraseña de Usuario' type='password' name='password' id='login-pass' required='true'><br>            
                Recuerdame<input type='checkbox' name='recordar'/><br>
             <input type='submit' value='Ingresar' name="submit"><br>
         </form> 
         <?php
}
         ?>    
    </nav>
    <div id='cuerpo_pagina'>
    