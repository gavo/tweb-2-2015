<?php 
	require('partesPagina/cabecera.php'); 
	if(!isset($_POST['submit'])){
?>
	<div id='div-form-login'>
        <form method="post" action="login.php">
            Usaurio<br>
            <input title="Necesita Ingresar un Nombre de Usuario" type="text" name="user" required><br>
            Contraseña<br>
            <input title="Necesita Ingresar un Nombre de Usuario" type="password" name="password" required><br>            
			Recuerdame<input type="checkbox" name="recordar"/><br>
            <input id="form-login-submit" type="submit" value='Ingresar' name="submit"><br>
        </form>
    </div>
<?php
	}else{
		$user = $_POST['user'];
		$pass = $_POST['password'];
		$recordar = false;
		if(isset($_POST['recordar'])) $recordar = $_POST['recordar'];
		loguear($user, $pass, $recordar);
	}
	require('partesPagina/piePagina.php');
?>