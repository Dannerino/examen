<?php
class mdlEdicion extends Singleton
{
    const PAGE = 'edicion';
    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) {
            return;
        }
        if (is_null(getPost('edicion'))) {
            if (!getGet('id')) redirectTo('index.php');
            $_SESSION[self::PAGE]['id'] = getGet('id');
            $datos = Viajes::searchIdDB(getGet('id'));
            if (count($datos) > 0) {
                // Utilizamos la validación para rellenar los campos del formulario.
                $val = Validacion::getInstance();
                $toValidate = $datos[0];
                $rules = array(
                    'nombre' => 'required|nombre',
                    'descripcion' => 'required|descripcion',
                    'precio' => 'required|precio',
                    'idTipo' => 'required|numeric|idTipo',
                    'foto' => '',
                );

                $val->addRules($rules);
                $val->run($toValidate);
            } else {
                redirectTo('index.php?pagina=mensaje');
            }
        } else {
            // Validamos
            $val = Validacion::getInstance();
            $toValidate = $_POST;
            $rules = array(
                'nombre' => 'required|nombre|duplicate',
                'descripcion' => 'required|descripcion',
                'precio' => 'required|precio',
                'idTipo' => 'required|numeric|idTipo',
                'foto' => '',
            );
            $nombre = getPost('nombre');
            $id = $_SESSION['edicion']['id'];
            $cliente = new SoapClient("http://localhost/examen/servicios/servicio.php?wsdl", array('cache_wsdl' => WSDL_CACHE_NONE));
            if ($cliente->duplicateName($nombre, $id)) {
                $val->setExists(true);
            }
            /*if (Viajes::duplicateName($nombre, $id)) {
                $val->setExists(true);
            }*/


            $val->addRules($rules);
            $val->run($toValidate);
            // Guardamos los datos en la sesión
            if ($val->isValid()) {
                $_SESSION[self::PAGE] = array_merge($_SESSION[self::PAGE], $val->getOks());
                // Guardamos en el array $data los datos de $_SESSION['edicion'] que sólo contiene el nombre pero el método Usuario::modifyDB espera un array
                $data = $_SESSION['edicion'];
                $id = $_SESSION[self::PAGE]['id'];
                $datos = Viajes::modifyDB($data, $id);
                if ($datos) {
                    $_SESSION['mod'] = true;
                } else {
                    $_SESSION['mod'] = false;
                }
                redirectTo('index.php?pagina=mensaje');
            }
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
        echo EdicionParser::loadContent($vista);
    }
}
