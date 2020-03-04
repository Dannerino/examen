<?php $val = Validacion::getInstance(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mensaje</title>
        <style>
            dl {
                padding-top: 50px;
            }
        </style>
        
    </head>
    <body>
    <h1>VIAJES CORRECAMINOS</h1>
        <form action="index.php?pagina=mensaje" method="post">
            {{mensaje}}
            <div id="menu">
                <ul>
                    <li><a href="?pagina=inicio">Volver a Inicio</a></li>

                    <li><a href="?pagina=busqueda">Volver a Busqueda</a></li>
                </ul>
            </div>
        </form>

        
    </body>
</html>