<?php
class mdlMensaje extends Singleton
{
    const PAGE = 'mensaje';
    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) {
            return;
        } 
        if (getGet('id')!=null) {
            $_SESSION[self::PAGE]['id'] = getGet('id');
            $datos = Viajes::searchDescripcionDB(getGet('id'));
            $_SESSION['descripcion'] = $datos;
        } 
    }
    public function onCargarVista($path)
    {
        if (getGet('pagina') != self::PAGE) {
            return;
        }
        ob_start();
        include $path;
        $vista = ob_get_contents();
        ob_end_clean();
        echo MensajeParser::loadContent($vista);
    }
}
