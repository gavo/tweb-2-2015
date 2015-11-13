<?php

	function query($sql){
		$mysqli = mysqli_connect('localhost','root','','avance');
		if($mysqli->connect_errno)
			die("No se pudo establecer la conexion MySQL: ".$mysql->connect_errno);
		$mysqli->query('use avance;');
		$resultado = false;
		$resultado = $mysqli->query($sql);
		$mysqli->close();		
		return $resultado;
	}

    function registrarCarrera($nombre, $sigla, $plan){
        $sql = "select * from carrera where nombre='".$nombre."' and sigla='".$sigla."' and plan='".$plan."'";
        $resultado = query($sql);
        while($fila = $resultado->fetch_assoc()){
            $resultado = false;
        }
        if($resultado == false){
            while($fila = $resultado->fetch_assoc()){
                echo '<h1>Error: La carrera '.$nombre.' con sigla '.$sigla.' perteneciente al plan '.$plan.' ya fue registrada Anteriormente</h1>'; 
            }
        }else{
            $resultado = query("insert into carrera(nombre,sigla,plan)values('".$nombre."','".$sigla."','".$plan."')");
            if($resultado){
                echo "<h1>Informacion Registrada</h1>";
                echo "<div id='div_form'>Nombre de la Carrera: ".$nombre.'<br>';
                echo "Sigla de la Carrera: ".$sigla.'<br>';
                echo "Plan de la Carrera: ".$plan;
                echo "</div>";
            }else{
                echo "No se pudo registrar la informacion";
            }
        }
    }
?>