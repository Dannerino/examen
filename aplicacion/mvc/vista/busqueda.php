
<?php $val = Validacion::getInstance(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Busqueda</title>
        <style>
            form {
                padding-top: 50px;
            }
            .has-error { background: red; color: white; padding: 0.2em; }
            .has-warning { background: blue; color: white; padding: 0.2em; }
        </style>
        
    </head>
    <body>
        <h1>VIAJES CORRECAMINOS</h1>
        <div class="container">
            <form action="index.php?pagina=busqueda" method="post">
                <h3>Busqueda</h3>
                {{errores}}
                <div>
                    <b>Localizar viajes</b> <br> <br> <br>
                    <label class=" {{class-opcion}}" for="opcion">Buscar por <b>Nombre</b> o <b>la ID del tipo de viaje (1 = Cultural, 2 = Deportivo, 3 = Turístico)</b>
                <br>No escriba nada para mostrar todos los viajes </label><br><br>
                    <input type="text" id="opcion" name="opcion"
                           value='<?php echo $val->restoreValue('opcion'); ?>' >
                    <span>{{war-opcion}}</span>
                </div>
                <br>
                <div>
                    <button type="submit" name="busqueda">Enviar </i></button>
                </div>
            </form>
            <a href="?pagina=inicio">Volver a Inicio</a>
        </div>
    </body>
</html>