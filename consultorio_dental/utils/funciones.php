<?php
    session_start();
	header('Content-Type: text/html; charset=UTF-8');
    date_default_timezone_set('America/La_Paz');
    require('constantes.php');
        
	function query($sql){
		$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB);
		if($mysqli->connect_errno)
			die("No se pudo establecer la conexion MySQL: ".$mysql->connect_errno);
		$mysqli->query('use '.DB_DB);
		$resultado = NULL;
		$resultado = $mysqli->query($sql);
		$mysqli->close();
		return $resultado;
	}
    
    function loguear($user, $pass, $recordar){		
		$sql = "SELECT * FROM `usuario` WHERE `usuario` = '".$user."' AND `password` = '".sha1($pass)."' AND `activo` ='1';";
		$resultado = query($sql);
    
        if($fila = $resultado->fetch_assoc()){
            $_SESSION['user']   = $fila['usuario'];				
            $_SESSION['rango']  = $fila['rango'];
            $_SESSION['id']  = $fila['id'];				
            if($recordar){
                setcookie('user', $_SESSION['user'], mktime()+86400);	
            }		
            header('location: index.php');		
        }else{
            echo "El Nombre de Usuario o su Password no Corresponden a una cuenta del Servidor o Su cuenta ha sido Bloqueada";
        }        
	}
    
    function buscarUsuario($usuario){
        if($_SESSION['rango']==2){
        $sql = "SELECT 	persona.`ci`, persona.`nombre`, persona.`apellido`, persona.`direccion`, persona.`telf`,
                    usuario.`activo`, usuario.`id`, usuario.`rango`, usuario.`usuario`
                FROM 
                    persona, usuario
                WHERE 
                    persona.`ci` = usuario.`ci`
                AND
                    `usuario` LIKE '".$usuario."';";
        }else{
        $sql = "SELECT 	persona.`ci`, persona.`nombre`, persona.`apellido`, persona.`direccion`, persona.`telf`,
                    usuario.`activo`, usuario.`id`, usuario.`rango`, usuario.`usuario`
                FROM 
                    persona, usuario
                WHERE 
                    persona.`ci` = usuario.`ci`
                AND
                    `usuario` LIKE '".$usuario."'
                AND 
                    `rango` = 0;";
        }
        return query($sql);
    }

    function buscarPersona($persona){
        if($_SESSION['rango']==2){
            $sql = "SELECT 	persona.`ci`, persona.`nombre`, persona.`apellido`, persona.`direccion`, persona.`telf`,
                        usuario.`activo`, usuario.`id`, usuario.`rango`, usuario.`usuario`
                    FROM 
                        persona, usuario
                    WHERE 
                        persona.`ci` = usuario.`ci`
                    AND
                        CONCAT(persona.`nombre`,' ',persona.`apellido`) LIKE '%".$persona."%'; ";
        }else{
            $sql = "SELECT 	persona.`ci`, persona.`nombre`, persona.`apellido`, persona.`direccion`, persona.`telf`,
                        usuario.`activo`, usuario.`id`, usuario.`rango`, usuario.`usuario`
                    FROM 
                        persona, usuario
                    WHERE 
                        persona.`ci` = usuario.`ci`
                    AND
                        CONCAT(persona.`nombre`,' ',persona.`apellido`) LIKE '%".$persona."%'
                    AND 
                        `rango` = 0;";
        }
        return query($sql);
    }
    
    function buscarPersonaCI($ci){
        if($_SESSION['rango']==2){        
            $sql = "SELECT 	persona.`ci`, persona.`nombre`, persona.`apellido`, persona.`direccion`, persona.`telf`,
                        usuario.`activo`, usuario.`id`, usuario.`rango`, usuario.`usuario`
                    FROM 
                        persona, usuario
                    WHERE 
                        persona.`ci` = usuario.`ci`
                    AND
                        persona.`ci` = '".$ci."';";
        }else{
            $sql = "SELECT 	persona.`ci`, persona.`nombre`, persona.`apellido`, persona.`direccion`, persona.`telf`,
                        usuario.`activo`, usuario.`id`, usuario.`rango`, usuario.`usuario`
                    FROM 
                        persona, usuario
                    WHERE 
                        persona.`ci` = usuario.`ci`
                    AND
                        persona.`ci` = '".$ci."'
                    AND 
                        `rango` = 0;";
        }
        return query($sql);
    }
    
    function regitrarActualizarDatosUsuario($ci, $nombre, $apellido, $direccion, $telf, $user, $pass,  $pass1, $rango, $activo, $update){
        if($pass!=$pass1){
            die('<div id="error">Error: la contraseña de verificacion no coincide con la contraseña asignada</div>');
        }
        if(strlen($pass)<4 && strlen($pass)!=0){
            die('<div id="error">Error: la contraseña es demaciado corta</div>');
        }
        
        $personaSelect = false;
        $sql = "SELECT *  FROM persona WHERE ci = '".$ci."';";
        $resultado = query($sql);
        if ($fila = $resultado->fetch_assoc()){
            $personaSelect = true;
        }
        
        $usuarioSelect = 0;
        $sql = "SELECT * FROM `usuario` where `usuario`='".$user."';";
        $resultado = query($sql);
        if($fila = $resultado->fetch_assoc()){
            if($fila['ci']==$ci){
                $usuarioSelect = 2;//la persona seleccionada es la misma
            }else{
                $usuarioSelect = 1;//la persona seleccionada es diferente
            }
        }
        
        if($update == 0){ 
            if(strlen($pass)==0){
                die("<div id='error'>El campo de contraseña no puede estar vacío</div>");
            }
            if($personaSelect){
                die("<div id='error'>Existe otra Persona registrada con ese CI</div>");
            }
            if($usuarioSelect != 0){
                die("<div id='error'>El nombre de usuario ".strtoupper($user)." está siendo ocupado por otra persona</div>");
            }
            $sql = "INSERT INTO `persona` (`ci`, `nombre`, `apellido`, `telf`, `direccion`) VALUES ('".$ci."', '".strtoupper($nombre)."', '".strtoupper($apellido)."', '".$telf."', '".strtoupper($direccion)."');";
            $resultado = query($sql);
            if($resultado){
                $sql = "INSERT INTO `usuario` (`usuario`,`password`,`rango`,`activo`,`ci`) VALUES ('".strtoupper($user)."','".sha1($pass)."','".$rango."','".$activo."','".$ci."');";
                $resultado = query($sql);
                if($resultado){
                    die("<div id='ok'>Usuario Registrado</div>");
                }else{
                    die("<div id='error'>No se pudo registrar el usuario</div>");
                }
            }else{
                die('<div id="error">No se pudo registrar a la Persona</div>');
            }
        }else{
            if(!$personaSelect){
                die("<div id='error'>No existe ninguna persona con ese CI</div>");
            }
            if($usuarioSelect == 1){
                die("<div id='error'>El nombre de usuario ".strtoupper($user)." está siendo ocupado por otra persona</div>");
            }
            $sql = "UPDATE `persona` SET `nombre` = '".strtoupper($nombre)."' , `apellido` = '".strtoupper($apellido)."' , `telf` = '".$telf."' , `direccion` = '".strtoupper($direccion)."' WHERE `ci` = '".$ci."';";
            $resultado = query($sql);
            if($resultado){
                $sql = "UPDATE `usuario` SET `usuario` = '".$user."' ";
                if(strlen($pass)!=0){
                    $sql .= ", `password` = '".sha1($pass)."'";
                }
                $sql .= ", `rango` = '".$rango."' , `activo` = '".$activo."' WHERE `ci` = '".$ci."';";
                $resultado = query($sql);
                if($resultado){
                    die("<div id='ok'>Usuario Actualizado</div>");
                }        
            }
            die("<div id='error'>No se pudo actualizar el usuario</div>");        
        }
    }
    
    function listarDoctores(){
        $sql = "SELECT  CONCAT(persona.`nombre`,' ',persona.`apellido`) doctor, usuario.`id`
                FROM persona, usuario
                WHERE persona.`ci` = usuario.`ci`
                AND usuario.`rango` = '1' AND usuario.`activo` = '1'; ";
         return query($sql);
    }
    
    function registrarCita($fecha, $doctor, $paciente){
        $sql = "INSERT INTO `cita`(`fecha`, `paciente`, `doctor`, `atendida`)VALUES('".$fecha."', '".$paciente."', '".$doctor."', '0');";
        $resultado = query($sql);
        if($resultado){
            die("<div id='ok'>Cita Registrada Correctamente</div>");
        }
        die("<div id='error'>No se pudo registrar la cita</div>");        
    }
    
    function tengoCitaTomorrow($fecha){
        $sql = "SELECT * FROM cita WHERE fecha='".$fecha."' AND paciente='".$_SESSION['id']."';";
        $resultado = query($sql);
        if($row = $resultado->fetch_assoc()){
            return true;
        }
        return false;        
    }
    
    function tengoCitaCanceladaTomorrow($fecha){
        $sql = "SELECT * FROM cita WHERE fecha='".$fecha."' AND paciente='".$_SESSION['id']."' AND atendida ='2';";
        $resultado = query($sql);
        if($row = $resultado->fetch_assoc()){
            return true;
        }
        return false;
    }
    
    function cancelarCita($fecha){
        $sql = "UPDATE cita SET atendida = '2' WHERE fecha='".$fecha."' AND paciente='".$_SESSION['id']."';";
        $resultado = query($sql);
        if($resultado){
            die("<div id='ok'>Cita Cancelada Correctamente</div>");
        }
        die("<div id='error'>No se pudo cancelar la cita</div>");        
    }
    
    function listarCitasDeHoy($fecha){
        $sql = "SELECT cita.`id` id_cita, cita.`atendida`, cita.`paciente` id_paciente, CONCAT(persona.`nombre`,' ',persona.`apellido`) nombre_paciente
                FROM cita, usuario, persona 
                WHERE cita.`paciente` = usuario.`id` AND usuario.`ci` = persona.`ci` AND cita.`fecha`='".$fecha."' AND cita.`atendida`IN('0','1') AND cita.`doctor`='".$_SESSION['id']."' 
                ORDER BY cita.`id`;";
        $consultas = query($sql);
        echo "<table> <tr><th>Nro</th><th>Estado</th><th>Paciente</th></tr>";  
        $i = 1;              
        while($cita = $consultas->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$i++."</td>";
            if($cita['atendida']==1) {echo "<td>Atendida</td>";}
            if($cita['atendida']==0) {echo "<td>Por Atender</td>";}
            echo "<td>".$cita['nombre_paciente']."</td>";
            echo '<th><button onclick="window.location = \'cita.php?cita='.$cita['id_cita'].'\'">Atender Cita</button>';
            echo "</tr>";
        }
        echo "</table>";
    }
    
    function cargarDatosCita($id_cita){
        $sql = "SELECT cita.`fecha`, usuario.`ci`, CONCAT(persona.`nombre`,' ',persona.`apellido`) persona , cita.`paciente`, cita.`atendida`
                FROM cita, usuario, persona
                WHERE cita.`id`= '".$id_cita."' AND persona.`ci` = usuario.`ci` AND cita.`paciente` = usuario.`id`";
        $usuario = query($sql);
        $usuario = $usuario->fetch_assoc();
        return $usuario;// usuario[fecha,ci,paciente]
    }
    
    function cargarHistorialPaciente($id_paciente){
        $sql = "SELECT cita.`fecha`, historial.`detalle`, historial.`tratamiento`, historial.`observaciones`
                FROM cita, historial
                WHERE cita.`id` = historial.`id_cita`
                AND cita.`paciente` = '".$id_paciente."';";
        return query($sql);
    }
    
    function  registrarDatosHistoricosCita($detalleCita, $tratamientoCita, $observacionesCita, $idCita){
        $sql = "INSERT INTO historial(`detalle`, `tratamiento`, `observaciones`, `id_cita`) VALUES ('".$detalleCita."','".$tratamientoCita."','".$observacionesCita."','".$idCita."');";
        $resultado = query($sql);
        if($resultado){
            $sql = "UPDATE cita SET cita.`atendida`='1' WHERE cita.`id`='".$idCita."'";
            $resultado = query($sql);
            if($resultado){
                die("<div id='ok'>Datos delacias archivados en datos Historicos del paciente</div>");
            }
        }
        die("<div id='error'>No se pudieron registrar los datos de la cita</div>");        
    }
    
    function verificarNombreDeNuevoUsuario($m_user){
        $sql = "SELECT * FROM usuario WHERE usuario.`usuario` = '".strtoupper($m_user)."';";
        $res = query($sql);
        if($row = $res->fetch_assoc()){
            if($row['id']!=$_SESSION['id'])
                die('<div id="error">Nombre de Usuario No disponible</div>');
        }
        return true;
    }
    
    function actualizarDatosUsuario($m_user, $pass, $pass1){
        verificarNombreDeNuevoUsuario($m_user);
        if($pass != $pass1){
             die("<div id='Las contraseñas no Coinciden'>No disponible</div>");
        }
        if(strlen($m_user) < 4){
            die('<div id="error">El Nombre de Usuario es muy Corto</div>');
        }
        if(strlen($pass)!=0 && strlen($pass)<4){
            die('<div id="error">La contraseña es muy corta</div>');
        }
        $sql = "UPDATE usuario SET usuario.`usuario` = '".strtoupper($m_user)."'";
        if(strlen($pass)>4){
            $sql.=", usuario.`password` = '".sha1($pass)."'";
        }
        $sql.=" WHERE id='".$_SESSION['id']."';";
        $resultado = query($sql);
        if($resultado){
            $_SESSION['user'] = strtoupper($m_user);
            die('<div id="ok">Datos Actualizados</div>');
        }else{
            die('<div id="error">No se pudo actualizar la información</div>');
        }
    }
?>