function mostrarOcultarLogin(){
    if($('#login').is(':hidden')){
        $('#login').show();
    }else{
        $('#login').hide();    
    }
}
function mostrarOcultarOpcionesUsuario(){    
    if($('#opcionesUsuario').is(':hidden')){
        $('#opcionesUsuario').show();
    }else{
        $('#opcionesUsuario').hide();    
    }
}
function permitirSalida(){
    return (confirm('Esta a punto de cerrar sesión, ¿desea continuar?'));
}

function verDatosUsuario(ci){
    window.location.href = "usuario.php?ci="+ci+"&q=redir";
}

function validar_guardado_de_datos_de_usuario(update){
    if($('#nombre').val().length < 3){
        alert('El Nombre de la Persona no es válido, es demaciado corto');
        return false;
    }    
    if($('#apellido').val().length < 3){
        alert('El Apellido de la Persona no es válido, es demaciado corto');
        return false;
    }
    if($('#direccion').val().length < 10){
        alert('La Dirección donde vive de la Persona no es válida, es demaciado corta');
        return false;
    }
    if($('#telf').val().length < 4){
        alert('El Nro de Teléfono de la Persona no es válido, es demaciado corto');
        return false;
    }
    if($('#usuario').val().length < 4){
        alert('El Nombre de usuario no es Válido, es demaciado corto');
        return false;
    }
    if($('#pass').val() != $('#pass1').val()){
        alert('La verificación de contraseña no coincide con la contraseña que puso');
        return false;
    }
    registrarActualizarUsuario(update);
    return false;
}

function registrarActualizarUsuario(update){
    if(confirm('Desea guardar los datos del Usuario?')){
        dataString  = '';
		ci          = $('#ci').val();
		nombre      = $('#nombre').val();
        apellido    = $('#apellido').val();
		direccion   = $('#direccion').val();
		telf        = $('#telf').val();
		user        = $('#usuario').val();
        pass        = $('#pass').val();
        pass1       = $('#pass1').val();
        rango       = $('#rango').select().val();
        activo      = $('#activo').select().val();
		parametros  = {
                        "ci"        : ci,
                        "nombre"    : nombre,
                        "apellido"  : apellido,
                        "direccion" : direccion,
                        "telf"      : telf,
                        "user"      : user,
                        "pass"      : pass,
                        "pass1"     : pass1,
                        "rango"     : rango,
                        "activo"    : activo,
                        "update"    : update,
                        "t"         : "0"			
		}    
        $.ajax({
			type        : "POST",
			url	        : "utils/ajax.php",
			data        : parametros,
            beforeSend  : function(){
                                $("#lbl_msj").html('<img id="img-load" src="img/loader.gif"/>');
                          },
			success     : function(value){
                                setTimeout(function(){
                                    $('#lbl_msj').html(value);
                                }, 2000);
                          }
	    }); 
    }
}

function registrarCita(){
    if(confirm('Desea solicitar cita?')){
        $('#btn_reg_cita').hide();
        fecha       = $('#fecha').val();
        doctor      = $('#doctor').select().val();
        parametros  = {
                        "fecha"     : fecha,
                        "doctor"    : doctor,
                        "t"         : "1"
        }
        $.ajax({
			type        : "POST",
			url	        : "utils/ajax.php",
			data        : parametros,
            beforeSend  : function(){
                                $("#lbl_msj").html('<img id="img-load" src="img/loader.gif"/>');
                          },
			success     : function(value){
                                setTimeout(function(){
                                    $('#lbl_msj').html(value);
                                    $(location).attr('href','cita.php');
                                }, 2000);
                          }
		});
    }
}

function cancelarCita(){
    if(confirm('Desea cancelar su cita?')){
        fecha       = $('#fecha').val();
        doctor      = $('#doctor').select().val();
        parametros  = {
                        "fecha" : fecha,
                        "t"     : "2"
        }
        $.ajax({
			type        : "POST",
			url	        : "utils/ajax.php",
			data        : parametros,
            beforeSend  : function(){
                                $("#lbl_msj").html('<img id="img-load" src="img/loader.gif"/>');},
			success     : function(value){
                                setTimeout(function(){
                                    $('#lbl_msj').html(value); 
                                    $(location).attr('href','cita.php');
                                }, 2000);
			              }
		});
    }
}

function registrarAtencionCita(){
    if(confirm('Desea guardar los datos de la atención y cerrar la Cita?')){
        detalleCita         = $('#detalleCita').val();
        tratamientoCita     = $('#tratamientoCita').val();
        observacionesCita   = $('#observacionesCita').val();
        idCita              = $('#idCita').val();        
        parametros = {
                        "detalleCita"       : detalleCita,
                        "tratamientoCita"   : tratamientoCita,
                        "observacionesCita" : observacionesCita,
                        "idCita"            : idCita,
                        "t"                 : "3"
        }
        $.ajax({
			type        : "POST",
			url	        : "utils/ajax.php",
			data        : parametros,
            beforeSend  : function(){
                                $("#lbl_msj").html('<img id="img-load" src="img/loader.gif"/>');
                          },
			success     : function(value){
                                $('#btnatendercita').hide();
                                setTimeout(function(){
                                    $('#lbl_msj').html(value);$(location).attr('href','cita.php');
                                }, 2000);
                          }
		});
    }
}

function verificarNombreUsuario(user_actual){
    user = $('#m_usuario').val();
    user = user.toUpperCase();
    if(user == user_actual){
        $('#lbl_msj').html('<div id="ok">Nombre Actual</div>');
    }else{
        parametros = {
                        "user"    : user,
                        "t"       : "4"
        }
        $.ajax({
			type        : "POST",
			url	        : "utils/ajax.php",
			data        : parametros,
            beforeSend  : function(){ 
                                $("#lbl_msj").html('<img id="img-load" src="img/loader.gif"/>');
                          },
			success     : function(value){
                                setTimeout(function(){
                                    $('#lbl_msj').html(value);
                                }, 500); 
                          }
		});
    }
}

function validarDatosNuevoUsuario(){
    pass    = $('#pass').val();
    pass1   = $('#pass1').val();
    user    = $('#m_usuario').val();
    if(pass != pass1){
        alert('Las contraseñas no coinciden');
        return false;
    }
    if(pass.length != 0 && pass.length <4){
        alert('La contraseña es demaciado corta');
        return false;
    }
    if(user.length < 4){
        alert('El nombre de usuario es demaciado corto');
        return false;
    }
    return true;
}

function cambiarDatosMyUser(){
    if(validarDatosNuevoUsuario() && confirm("Desea Guardar los nuevos datos?")){
        user    = $('#m_usuario').val(); 
        pass    = $('#pass').val();
        pass1   = $('#pass1').val();
        parametros = {
                        "m_user"    : user,
                        "pass"      : pass,
                        "pass1"     : pass1,
                        "t"         : "5"
        }
        $.ajax({
			type        : "POST",
			url	        : "utils/ajax.php",
			data        : parametros,
            beforeSend  : function(){ 
                                $("#lbl_msj").html('<img id="img-load" src="img/loader.gif"/>');
                          },
			success     : function(value){
                                setTimeout(function(){
                                    $('#lbl_msj').html(value);
                                    setTimeout(function(){
                                        $(location).attr('href','modificarusuario.php');
                                    },5000);
                                }, 2000); 
                          }
		});
    }
}