<?php
    require('funciones.php');
    if(isset($_SESSION['rango'])){        
        if(isset($_POST['t'])){
            
            switch($_POST['t']){
				// caso de registro y actualizacion de usuario
				case 0:{
					if($_SESSION['rango']>0 && isset($_POST['ci']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['direccion']) &&
					isset($_POST['telf']) && isset($_POST['user']) && isset($_POST['pass'])&& isset($_POST['pass1']) && isset($_POST['rango']) &&
					isset($_POST['activo']) && isset($_POST['update']))
                    {
						regitrarActualizarDatosUsuario($_POST['ci'], $_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['telf'],  $_POST['user'], 
													   $_POST['pass'], $_POST['pass1'], $_POST['rango'], $_POST['activo'], $_POST['update']);
					}else{
						die('<div id="error">necesita más parámetros para la funcion</div>');
					}
				}
				
				// caso de registro de cita
				case 1:{
					if( $_SESSION['rango']==0  &&  isset($_POST['fecha'])  &&  isset($_POST['doctor'])){
						registrarCita($_POST['fecha'],  $_POST['doctor'], $_SESSION['id']);
					}else{
						die("<div id='error'>Faltan más parámetros para la función</div>");
					}
				}	   
				// caso de cancelacion de cita
				case 2:{
					if($_SESSION['rango']==0 && isset($_POST['fecha'])){
						cancelarCita($_POST['fecha']);
					}else{
						die("<div id='error'>Faltan más parámetros para la función</div>");
					}
				}
				
				// caso de registro de datos historicos en atencion de cita
				case 3:{
					if($_SESSION['rango']==1 && isset($_POST['detalleCita']) && isset($_POST['tratamientoCita']) && isset($_POST['observacionesCita']) && isset($_POST['idCita'])){
						registrarDatosHistoricosCita($_POST['detalleCita'], $_POST['tratamientoCita'], $_POST['observacionesCita'], $_POST['idCita']);   
					}else{
						die("<div id='error'>Faltan más parámetros para la función</div>");
					}
				}
                // caso de verificacion de Nombre de usuario
                case 4:{
                    if(isset($_POST['user'])){
                        if(verificarNombreDeNuevoUsuario($_POST['user'])){
                            die('<div id="ok">Disponible</div>');
                        }
                    }else{
                        die("<div id='error'> Faltan datos</div>");
                    }
                }
                // caso de actualizacion de datos de usuario
                case 5:{
                    if(isset($_POST['m_user']) && isset($_POST['pass']) && isset($_POST['pass'])){
                        actualizarDatosUsuario($_POST['m_user'],$_POST['pass'],$_POST['pass1']);
                    }else{
                        die("<div id='error'> Faltan datos</div>");
                    }
                }
            }
            
        }else{            
            die('<div id="error">necesita más parámetros</div>');
        }
        
    }else{
        die('<div id="error">Necesita Iniciar Sesión</div>');
    }
?>