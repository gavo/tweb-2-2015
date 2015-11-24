 <?php
    include('partesPagina/cabecera.php');
    $userSelected = false;
    echo "<h3>Gestion de Usuarios</h3>";
    if(isset($_GET['q'])){
        $usuario = NULL;
        if(isset($_GET['person'])){
            $usuario = buscarPersona($_GET['q']);
        }else{
            if(isset($_GET['user'])){
                $usuario = buscarUsuario($_GET['q']);
            }else{
                $usuario = buscarPersonaCI($_GET['ci']);
            }
        }        
        $row_cnt = mysqli_num_rows($usuario);
        if($row_cnt ==0 ){
            echo "<div id='form_registro'><h5>La búsqueda no arrojó Resultados</h5></div><br>";
        }
        if($row_cnt > 1){
            echo "<div id='form_registro'><h4>La búsqueda arrojó más de 1 resultado</h4>";
                echo "<table>
                <tr><th>CI</th><th>Nombre</th><th>Apellido</th><th>Rango del Usuario</th><th>Estado</th><th>Usuario</th></tr>";
                while($user = $usuario->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$user['ci']."</td>";
                    echo "<td>".$user['nombre']."</td>";
                    echo "<td>".$user['apellido']."</td>";
                    if($user['rango']==0){
                        echo "<td>Paciente</td>";
                    }else if($user['rango']==1){                        
                        echo "<td>Doctor</td>";
                    }else if($user['rango']==2){                        
                        echo "<td>Administrador de Sistemas</td>";
                    }
                    if($user['activo']==0){
                        echo "<td>Deshabilitado</td>";
                    }else{                        
                        echo "<td>Activo</td>";
                    }
                    echo "<td>".$user['usuario']."</td>";
                    echo '<th><button onClick ="verDatosUsuario('.$user['ci'].')">Ver Usuario</button></th>';
                    echo "</tr>";
                }
                echo "</table>";
        }else{
            $usuario = $usuario->fetch_assoc();
            $userSelected = true;
            
        }  
	}
 ?>
    <div id='form_registro'>
            <div id='sub_form_registro'>
                <B>Buscar Persona</b>
                <form method="get" action="usuario.php">
                    <input type="text" name="q">
                    <input type="submit" name="person" value="Buscar">                    
                </form><br>
            </div>
            <div id='sub_form_registro'>
                <B>Buscar Usuario</B>
                <form method="get" action="usuario.php">
                    <input type="text" name="q">
                    <input type="submit" name="user" value="Buscar">  
                </form><br>
            </div>
        </div>
    <form method='post' action='usuario.php' onSubmit="return false">        
        <div id='form_registro'> 
            <?php 
                if($userSelected){
                    echo "<h3>Editando Datos de Usuario "; 
                    echo strtoupper($usuario['usuario'])."</h3>";
                }else{
                    echo "<h3>Registrando Nuevo Usuario</h3>";
                }
                echo "<div id='lbl_msj'></div>";
            ?>   
            <div id='sub_form_registro'>
                <h4>Datos Personales</h4>
                CI<br><input type="text" name="ci" id='ci' value=<?php if($userSelected){echo "'".$usuario['ci']."'"; echo "readonly='readonly'";}?>><br>
                Nombre<br><input type="text" name="nombre" id='nombre' value="<?php if($userSelected){echo $usuario['nombre'];}?>"><br>
                Apellidos<br><input type="text" name="apellido" id='apellido' value="<?php if($userSelected){echo $usuario['apellido'];}?>"><br>
                Dirección<br><input type="text" name="direccion" id='direccion' value="<?php if($userSelected){echo $usuario['direccion'];}?>"><br>
                Teléfono<br><input type="text" name="telf" id='telf' value="<?php if($userSelected){echo $usuario['telf'];}?>"><br><br>
            </div>
            
            <div id='sub_form_registro'>
                <h4>Datos de Usuario</h4>
                Nombre de Usuario<br><input type="text" id="usuario" name="user" value="<?php if($userSelected){echo $usuario['usuario'];}?>"><br>
                Contraseña<br><input type="password" name="pass" id='pass'><br>
                Verificación de Contraseña<br><input type="password" name="pass1" id='pass1'><br>
                Tipo de Usuario<br>                 
                <select name='rango' id="rango">
                    <?php 
                        if($_SESSION['rango']==1){ 
                            echo "<option value='0'  value='";
                            if($userSelected){
                                if($usuario['rango']==0){
                                    echo "selected";
                                }
                            }else{
                                echo "selected";
                            }
                            echo "'>Paciente</option>";
                        }
                        
                        if($_SESSION['rango']==2){
                            echo "<option value='1'";
                            if($userSelected){
                                if($usuario['rango']==1)
                                    echo "selected";
                            }
                            echo ">Doctor</option>";
                            
                            echo "<option value='2' ";                        
                            if($userSelected){
                                if($usuario['rango']==2)
                                    echo "selected";
                            }
                            echo ">Administrador de Sistemas</option>";
                        }?> 
            	</select><br>
                Estado del Usuario<br>
                <select name="activo" id="activo">
                    <option value='0' <?php if($userSelected){if($usuario['activo']==0)echo "selected";}?>>Usuario Inactivo</option>
                    <option value='1' <?php if($userSelected){if($usuario['activo']==1)echo "selected";}?>>Usuario Activo</option>
                </select><br><br>              
            </div>
            <input type="submit" onClick="validar_guardado_de_datos_de_usuario(<?php if($userSelected){echo "1";}else{echo "0";}?>)" value=<?php 
                if($userSelected){
                    echo "'Actualizar Usuario' name='update_data'";
                }else{
                    echo "'Registrar Usuario' name='register_data'";
                }?> >       
        </div><br>
    </form><br>
 <?php
    include('partesPagina/piePagina.php');
 ?>