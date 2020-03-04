<?php

class Viajes
{

    public static function searchIdDB($id)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->select('viajes', '*', ["id[=]" => $id]);
        $database->closeConnection();
        return $datos;
    }

    public static function searchDescripcionDB($id)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->select('viajes', 'descripcion', ["id[=]" => $id]);
        $database->closeConnection();
        return $datos;
    }

    public static function searchNombreDB($nombre)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->select('viajes', '*', ["nombre[=]" => $nombre]);
        $database->closeConnection();
        return $datos;
    }

    public static function searchNomIdDB($data)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->select('viajes', '*', [
            "OR" => [
                "nombre[~]" => $data,
                "idTipo[]" => $data
            ]
        ]);

        $database->closeConnection();
        return $datos;
    }

    public static function searchAllIdDB()
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->select('viajes', '*');
        $database->closeConnection();
        return $datos;
    }

    public static function modifyDB($data, $id)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->update('viajes', $data, ['id' => $id]);
        $database->closeConnection();
        return $datos;
    }

    public static function insertDB($data)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->insert('viajes', $data);
        $database->closeConnection();
        return $datos;
    }

    public static function insertSalidasDB($data)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->insert('salidas', $data);
        $database->closeConnection();
        return $datos;
    }

    public static function removeDB($id)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->delete('viajes', ['id[=]' => $id]);
        $datos = $datos->rowCount() > 0 ? true : false;
        $database->closeConnection();
        return $datos;
    }

    public static function duplicateSalidas($ciudad, $idViaje = null)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = ($database->count('salidas', ["AND" => ['ciudad' => $ciudad, 'idViaje[!]' => $idViaje]]) > 0) ? true : false;
        $database->closeConnection();
        return $datos;
    }

    public static function nombreTipo($id)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->select('tipos', 'tipo', ["id[=]" => $id]);
        $database->closeConnection();
        return $datos;
    }

    public static function insertDBViaje($data) {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        // Comienza la transaccion
        $database->pdo->beginTransaction();
        $viaje = array();
        $salidas = array();
        foreach ($data as $field=>$value) {
            if (!$value) continue;// no trata el botón de envío de formulario
            if ($field == 'salida1' || $field == 'salida2')
                $salidas[] = $value;
            else
                $viaje[$field] = $value;
        }
        $datos = UnViaje::insertDB($viaje);
        if ($datos) {
            // almacenamos el último id insertado
            $id = $database->pdo->lastInsertId();
            foreach ($salidas as $sal) {
                $salida['idViaje']= $id;
                $salida['ciudad']=$sal;
                $datos = Salidas::insertDB($salida);
            }
        }
        if ($datos)
            $database->pdo->commit();
        else
            $database->pdo->rollBack();
        $database->closeConnection();
        return $datos;
    }

    public static function salidas($id){

        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->select('salidas', 'ciudad',['idViaje' => $id]);
        $database->closeConnection();
        return $datos;

    }

    public static function removeDBViajes($id){

        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = UnViaje::removeDB($id);
        $datos = Salidas::removeDB($id);
        $database->closeConnection();
        return $datos;
    }

    public static function duplicateName($nombre, $id = null)
    {
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = ($database->count('viajes', ["AND" => ['nombre' => $nombre, 'id[!]' => $id]]) > 0) ? true : false;
        $database->closeConnection();
        return $datos;
    }

    public static function existeTipo($tipo){
        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = ($database->count('tipos', ['id' => $tipo]) > 0) ? true : false;
        $database->closeConnection();
        return $datos;
    }
}