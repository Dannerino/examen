<?php

class mdlEliminacion extends Singleton
{
    const PAGE = 'eliminacion';

    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) return;
        $datos = Viajes::removeDBViajes(getGet('opcion'));

        if ($datos)
            $_SESSION['elim'] = true;
        else
            $_SESSION['elim'] = false;

        $_SESSION[self::PAGE] = true;
        redirectTo('index.php?pagina=mensaje');
    }
}