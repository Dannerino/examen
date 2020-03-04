<?php $val = Validacion::getInstance(); ?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Añadir</title>
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
    <div>
        <form action="index.php?pagina=insercion" method="post" enctype="multipart/form-data">
            <h3>Insertar</h3>


            {{errores}}
            <div>
                <label class=" {{class-nombre}}" for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value='<?php echo $val->restoreValue('nombre'); ?>'>
                <span>{{war-nombre}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-descripcion}}" for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" value='<?php echo $val->restoreValue('descripcion'); ?>'>
                <span>{{war-descripcion}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-idTipo}}" for="idTipo">idTipo</label>
                <input type="text" id="idTipo" name="idTipo" onkeyup="validarTipo()" value='<?php echo $val->restoreValue('idTipo'); ?>'>
                <span id="idTipoSpan">{{war-idTipo}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-precio}}" for="precio">Precio</label>
                <input type="text" id="precio" name="precio" value='<?php echo $val->restoreValue('precio'); ?>'>
                <span>{{war-precio}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-salida1}}" for="salida1">Salida 1º</label>
                <input type="text" id="salida1" name="salida1" value='<?php echo $val->restoreValue('salida1'); ?>'>
                <span>{{war-salida1}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-salida2}}" for="salida2">Salida 2º</label>
                <input type="text" id="salida2" name="salida2" value='<?php echo $val->restoreValue('salida2'); ?>'>
                <span>{{war-salida2}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-foto}}" for="foto">Foto</label>
                <input type="file" id="foto" name="foto" value=''>
                <span>{{war-foto}}</span>
            </div>
            <br>

            <div>
                <button type="submit" name="insercion" id="insercion">Insertar</i></button>
            </div>
        </form>
    </div>
    <div id="menu">
        <ul>
            <li><a href="?pagina=inicio">Volver a Inicio</a></li>

        </ul>
    </div>
    <script type="text/javascript" src="js/validacion.js"></script>
</body>

</html>