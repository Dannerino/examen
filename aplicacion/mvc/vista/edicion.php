<?php $val = Validacion::getInstance(); ?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modificar</title>
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
    <div class="container">
        <form action="index.php?pagina=edicion" method="post" enctype="multipart/form-data">
            <h3>Modificar</h3>
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
                <input type="text" id="idTipo" name="idTipo" value='<?php echo $val->restoreValue('idTipo'); ?>'>
                <span>{{war-idTipo}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-precio}}" for="precio">Precio</label>
                <input type="text" id="precio" name="precio" value='<?php echo $val->restoreValue('precio'); ?>'>
                <span>{{war-precio}}</span>
            </div>
            <br>
            <div>
                <label class=" {{class-foto}}" for="foto">Foto</label>
                <input type="text" id="foto" name="foto" value='<?php echo $val->restoreValue('foto'); ?>'>
                <span>{{war-foto}}</span>
            </div>
            <br>
            <div>
                <button type="submit" name="edicion">Enviar </i></button>
            </div>
        </form>
    </div>
    <br>
    <a href="index.php">Volver a Inicio</a>
</body>

</html>