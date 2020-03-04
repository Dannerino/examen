<!------ HOSPITAL / EMPLEADOS ------->

<?php

class mdlMenu extends Singleton
{
    const PAGE = 'inicio';

    public function onGestionPagina()
    {
        if (self::PAGE != getGet('pagina', 'inicio')) return;
    }

    public function onCargarVista($path)
    {
        if (self::PAGE != getGet('pagina', 'inicio')) return;

        ob_start();
        include $path;
        $vista = ob_get_contents();
        ob_end_clean();
        echo $vista;
    }
}