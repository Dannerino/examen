<?php

class mdlInsercion extends Singleton
{
    const PAGE = 'insercion';

    public function onGestionPagina()
    {
        if (getGet('pagina') != self::PAGE) return;
// Validamos
        $val = Validacion::getInstance();
// Validamos los elementos que hay en $_POST
        $toValidate = ($_POST);
        $rules = array(
            'nombre' => 'required|nombre|duplicate',
            'descripcion' => 'required|descripcion',
            'precio' => 'required|precio',
            'idTipo' => 'required|numeric|idTipo',
            'salida1' => 'required|salida',
            'salida2' => 'repeated',
            'foto' => 'foto'
        );
        $nombre = getPost('nombre');
        $cliente = new SoapClient("http://localhost/examen/servicios/servicio.php?wsdl",array('cache_wsdl' => WSDL_CACHE_NONE));
        if ($cliente->duplicateName($nombre)) {
            $val->setExists(true);
        }
        /*if (Viajes::duplicateName($nombre)){
            $val->setExists(true);
        }*/
        $salida1 = getPost('salida1');
        $salida2 = getPost('salida2');
        if ($salida1 == $salida2)
            $val->setSalidaRepeat(true);

        $val->addRules($rules);

        // Comprobación de los campos y evitar que salten errores la primera vez que entras
        if(isset($_POST['insercion'])){
            $toValidate=array();
            foreach($rules as $key => $valor){
                $toValidate[$key]=getPost($key);
            }
             $toValidate =array_merge($toValidate, $_FILES);
            }

        $val->run($toValidate);
        if (!is_null(getPost(self::PAGE))) {
            if ($val->isValid()) {
// Guardamos los datos en session
                $_SESSION[self::PAGE] = $val->getOks();
                // Cambia la inserción de la foto para guardar solo el nombre
                $_SESSION['insercion']['foto'] = $_SESSION['insercion']['foto']['name'];
                

                $data = $_SESSION['insercion'];
               
                $datos = Viajes::insertDBViaje($data);
                if ($datos)
                    $_SESSION['ins'] = true;
                else
                    $_SESSION['ins'] = false;
// Cambiamos el paso
                redirectTo('index.php?pagina=mensaje');
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
        echo InsercionParser::loadContent($vista);
    }
}

?>