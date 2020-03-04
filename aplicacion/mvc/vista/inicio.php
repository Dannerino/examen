<?php $val = Validacion::getInstance(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <style>
        form {
            padding-top: 50px;
        }

        .has-error {
            background: red;
            color: white;
            padding: 0.2em;
        }

        .has-warning {
            background: blue;
            color: white;
            padding: 0.2em;
        }
    </style>
    
</head>
<body>
<h1>VIAJES CORRECAMINOS</h1>
<H3>Menu de inicio</H3>
<div id="menu">
    <ul>
        <li><a href="?pagina=insercion">Añadir nuevos viajes</a></li>
        <li><a href="?pagina=busqueda">Busqueda de viajes</a></li>
    </ul>
</div>
<br>
</body>
</html>