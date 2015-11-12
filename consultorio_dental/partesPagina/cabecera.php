<!DOCTYPE html>
<head>
	<meta http-equiv = 'Content-Type' 	content = 'text/html; charset=utf-8'>
  	<meta name="Author" content="Gimena Burneett">
  	<meta name="Keywords" content="javascript, html">
  	<meta name="Description" content="Proyecto Final Tecnología Web">
    <link rel = 'shortcut icon' href = 'img/icon.gif'> 
  	<link href="estilo.css" rel="stylesheet" type="text/css">
    <title>Consultorio Dental</title>
</head>
<body>
    <header>
        <img src="img/logo.png">
    </header>
    <nav>  
        <a href="<?php echo $categorias;?>">Inicio</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo $categorias;?>">Registrar Usuario</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo $buscar;?>">Reservar Consulta</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo $categorias;?>">Ver Citas</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo $buscar;?>">Atender Citas</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo $host;?>">Iniciar Sesion</a>&nbsp;&nbsp;&nbsp;&nbsp; 
    </nav>
    <div id='cuerpo_pagina'>
    