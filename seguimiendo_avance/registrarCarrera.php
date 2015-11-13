 <?php
    include('partesPagina/cabecera.php');
    if(isset($_POST['nombre']) && isset($_POST['sigla']) && isset($_POST['plan'])){
        registrarCarrera($_POST['nombre'],$_POST['sigla'],$_POST['plan']);
    }else{
?>
	<h3>Registrar Carrera</h3>
    <div id='div_form'>
    <form action="registrarCarrera.php" method="post" onSubmit="return validarRegistroCarrera()">
        Nombre de la Carrera : <input type="text" name="nombre" id='nombreCarrera'><br>
        Sigla de la Carrera : <input type="text" name="sigla" id='siglaCarrera'><br>
        Plan de la Carrera : <input type="text" name="plan" id='planCarrera'><br>
        <input type="submit" name="boton" value="Registrar Carrera">
    </form>
    </div>
    
<?php 
    }
    include('partesPagina/piePagina.php');
 ?>