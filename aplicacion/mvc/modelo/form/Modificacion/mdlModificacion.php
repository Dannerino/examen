<?php

class mdlModifiacion extends Singleton
{
    const PAGE = 'modificacion';

    public function onGestionPagina()
    {
// ¡¡¡Cuidado!!!, aqui no se puede por la condición de siempre: if (getGet('pagina') != self::PAGE|| count($_POST) <= 0) return;
// porque a esta página se llega sin pulsar un botón.
        if (getGet('pagina') != self::PAGE) return;


// Validamos
        $val = Validacion::getInstance();
        $toValidate = $_POST;
        $rules = array(
            'idCat' => 'required',

        );
        $val->addRules($rules);
        $val->run($toValidate);
        if (!is_null(getPost(self::PAGE))) {
            if ($val->isValid()) {
// Guardamos los datos en session
                $_SESSION[self::PAGE] = $val->getOks();
// Cambiamos el paso
                redirectTo('index.php?pagina=edicion');
            }
        }
    }


    public function onCargarVista($path)
    {
        if (getGet('pagina') != self::PAGE) return;
        ob_start();
        include $path;
        $vista = ob_get_contents();
        ob_end_clean();
        echo ModificacionParser::loadContent($vista);
    }
}
