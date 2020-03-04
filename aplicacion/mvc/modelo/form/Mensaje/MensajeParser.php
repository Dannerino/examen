<?php

class MensajeParser
{
    public static function loadContent($vista)
    {
        $vista = self::_pasoSiguiente($vista);
        return $vista;
    }

    private static function _pasoSiguiente($vista)
    {
        foreach (getTagsVista($vista) as $tag) {
            // sustituimos en el formulario los tags por el contenido de los elementos del formulario
            $str = '';
            switch ($tag) {
                case 'mensaje':
                    // Si existe $_SESSION['edicion'] es que el ID introducido a través del formulario existe
                    if (isset($_SESSION['eliminacion'])) {
                        if ($_SESSION['elim']) {
                            Session::del('eliminacion');
                            $str = '<p> <b>Viaje eliminado</b></p>';
                        } else {
                            $str = '<p> <b>No se ha podido eliminar este viaje</b></p>';
                        }
                    } elseif (isset($_SESSION['edicion'])) {
                        if ($_SESSION['mod']) {
                            Session::del('edicion');
                            $str = '<p> <b>Viaje modificado</b></p>';
                        } else {
                            $str = '<p> <b>No se han podido modificar los datos...</b></p>';
                        }
                    } elseif (isset($_SESSION['insercion'])) {
                        if ($_SESSION['ins']) {
                            Session::del('insercion');
                            $str = '<p> <b>El registro se ha realizado correctamente</b></p>';
                        } else {
                            $str = '<p> <b>No se ha podido almacenar este viaje</b></p>';
                        }
                    } elseif(isset($_SESSION['descripcion'])) {
                        $str = "<b>La descripción de este viaje es:</b> " .$_SESSION['descripcion'][0];
                        Session::del('descipcion');
                    }
                    else {
                        $str = '<p> <b>El viaje no existe</b></p>';
                    }
                    break;
            }
            $vista = str_replace('{{' . $tag . '}}', $str, $vista);
        }
        return $vista;
    }
}