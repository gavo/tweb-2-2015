 <?php
    include('partesPagina/cabecera.php');
 ?>
    <h3>Modificar Datos de Usuario</h3>
    <form method='post' action='usuario.php' onSubmit="return false">        
        <div id='form_registro'>
            <div id='sub_form_registro' style="float:none; display:inline-block;">
                <br>Nombre de Usuario<div id='lbl_msj' ></div><br>
                <input type="text" id="m_usuario" name="user" value="<?php echo $_SESSION['user'];?>" onBlur="verificarNombreUsuario(<?php echo "'".$_SESSION['user']."'";?>)"><br>
                Contraseña<br><input type="password" name="pass" id='pass'><br>
                Verificación de Contraseña<br><input type="password" name="pass1" id='pass1'><br><br>
            <input type="submit" onClick="cambiarDatosMyUser()" value="Actualizar Datos">  <br><br>
            </div><br>
        </div><br>
    </form>    
 <?php
    include('partesPagina/piePagina.php');
 ?>