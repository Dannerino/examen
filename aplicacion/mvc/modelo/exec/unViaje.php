<?php
class UnViaje {
    public static function insertDB($data) {
        $database = medoo::getInstance();
        // ojo!!!: no abrimos conexión
        $datos = $database->insert('viajes', $data);
        // ojo!!!: no cerramos conexión
        return $datos;
    }

    public static function removeDB($id){

        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->delete('viajes', ['id[=]' => $id]);
        $datos = $datos->rowCount() > 0 ? true : false;
        $database->closeConnection();
        return $datos;

    }

    public static function modifyDB($data, $id) {
        $database = medoo::getInstance();
        $datos = $database->update('viajes', $data, ['id' => $id]);
        return $datos;
        }

}