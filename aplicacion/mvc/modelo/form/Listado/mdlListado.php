<?php

class mdlListado extends Singleton
{
    const PAGE = 'listado';

    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) return;

        if (!(isset($_SESSION['busqueda']))) {

            $_SESSION['datos'] = Viajes::searchAllIdDB();
        } else {
            $_SESSION['datos'] = $_SESSION['busqueda'];
        }

    }

    public function onCargarVista($path)
    {
        if (getGet('pagina') != self::PAGE) return;
        ob_start();
        include $path;
        $vista = ob_get_contents();
        ob_end_clean();
        echo ListadoParser::loadContent($vista);
    }
}

?>