 <?php
    include('partesPagina/cabecera.php');
    if(isset($_SESSION['rango'])){
        if($_SESSION['rango']==1){
            if(isset($_GET['cita'])){
                $datosCita = cargarDatosCita($_GET['cita']);
                echo "<h3>Atendiendo Paciente ".$datosCita['persona']."</h3>";
                echo '<div id="form_registro"  style="width:96%";>';
                echo '<div id="sub_form_registro" style="float:none; display:inline-block; width:96%;">';
                $historial = cargarHistorialPaciente($datosCita['paciente']);
                echo "<h4>Historial del Paciente</h4>";
                echo "<table>";
                echo "<tr>
                          <th>Fecha</th>
                          <th>Detalle</th>
                          <th>Tratamiento</th>
                          <th>Observaciones</th>
                      </tr>";
                while($cita = $historial->fetch_assoc()){
                    ?>
                        <tr>
                            <td><?php echo $cita['fecha'];?></td>
                            <td><?php echo $cita['detalle'];?></td>
                            <td><?php echo $cita['tratamiento'];?></td>
                            <td><?php echo $cita['observaciones'];?></td>
                        </tr>
                    <?php
                }
                echo "</table>";
                echo "</div></div>";
                
                if($datosCita['atendida']==0){
                echo '<div id="form_registro"  style="width:96%;">';
                echo '<div id="sub_form_registro" style="float:none; display:inline-block; width:96%;">';
                    echo '<h4>Detalles de la Atención</h4>';
                    ?>
                        <div id='lbl_msj'></div>
                        <form method="get" onSubmit="return false" action="cita.php">
                            Detalles de la Atención<br><textarea name="detalleCita" id="detalleCita"></textarea><br>
                            Tratamiento recetado al paciente<br><textarea name="tratamientoCita" id="tratamientoCita"></textarea><br>
                            Observaciones durante la atención<br><textarea name="observacionesCita" id="observacionesCita"></textarea><br>
                            <input type="hidden" name="idCita" id="idCita" value="<?php echo $_GET['cita'];?>">
                            <input type="submit" onClick="registrarAtencionCita()" value="Guardar detalles de Atención y Cerrar Cita" id="btnatendercita">
                        </form>
                    <?php                
                    echo "</div></div>";
                }else{
                    echo '<div id="form_registro"  style="width:96%;">';
                    echo '<div id="sub_form_registro" style="float:none; display:inline-block; width:96%;">'; 
                    echo '<h3>La Cita ya fue atendida</h3>';
                    echo "</div></div>";
                }
            }else{
 ?>
                <h3>Viendo Citas del día</h3>
                <div id='form_registro' style="width:90%;">
                    <div id='sub_form_registro' style="float:none; display:inline-block; width:95%;">
                        <?php listarCitasDeHoy(date('Y-m-d', time()));?>
                    </div>
                </div>
 <?php      }
        }
        if($_SESSION['rango']==0){
            $dia_cita = date('Y-m-d', time()+84600);            
            if(!tengoCitaTomorrow($dia_cita)){
?>
        <h3>Reservación de Cita</h3>
        <div id='lbl_msj'></div>
            <form action="cita.php" method="post" onSubmit="return false">
        <div id='form_registro'>
        <div id='sub_form_registro' style="float:none; display:inline-block">
                <h3>Datos de la Cita</h3>
                Fecha de atención de la Cita <input name="fecha" id='fecha' type="date" value="<?php echo $dia_cita?>" readonly='readonly'><br><br>
                Doctor que atenderá <br> <select name="doctor" id='doctor'>
                        <?php
                           $doctores = listarDoctores();
                           while($doctor = $doctores->fetch_assoc()){
                                echo "<option value='".$doctor['id']."'>".$doctor['doctor']."</option>";
                           }                           
                        ?>
                        </select><br><br>
                        <input type="submit" value="Registrar Cita" name='citar' onClick="registrarCita()" id="btn_reg_cita"><br><br>
        </div>
        </div>
            </form>
        
<?php
            }else{?>
                <h3>Cancelar la Cita para mañana</h3>
                <div id='lbl_msj'></div>
                <p>Una vez cancelada la cita, no podrá solicitar cita hasta mañana, para el día de pasado mañana, porfavor tomar en cuenta antes de cancelar su cita</p>
                <p>Todas las Citas se realizan con un dia de anticipacion, en caso de cancelarla se le ruega tratar de hacerlo antes de que termine el dia para no hacer esperar a los doctores en vano mañana, Gracias por su comprención</p>
                <?php if(tengoCitaCanceladaTomorrow($dia_cita)){
                    echo "<h4><div id='error'>Usted canceló su cita para mañana</div></h4>";
                }else{
                    ?>
                    <button onClick="cancelarCita()" name="btn_reg_cita" id="btn_reg_cita" value="cancelar Cita">Cancelar Cita</button>
                    <input name="fecha" id='fecha' type="hidden" value="<?php echo $dia_cita?>" readonly='readonly'>
                    <?php
                }
            }
        }
    }else{
        echo "<h3>Error al cargar la página</h3><div id='error'>Usted no está autorizado para estar en esta página</div>";
    }
    include('partesPagina/piePagina.php');
 ?>