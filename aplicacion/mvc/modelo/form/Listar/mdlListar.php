<?php
class mdlListar extends Singleton
{
    const PAGE = 'listar';
    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) {
            return;
        }
        $_SESSION[self::PAGE] = true;
        $_SESSION['datos'] = Articulos::searchAllIdDB();
        redirectTo('index.php?pagina=listado');
    }
}
