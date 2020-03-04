<?php
class Salidas {
    static private $_sql;
    static private $_query;
    public static function insertDB($data) {
        $database = medoo::getInstance();
        // ojo!!!: no abrimos conexión
        $sql = "insert into salidas (idViaje, ciudad) values (:idViaje, :ciudad)";
        $param= array(":idViaje" => $data['idViaje'],":ciudad" => $data['ciudad'] );
        // Sólo se prepara la consulta con el primer teléfono
        if (self::$_sql != $sql) {
            self::$_query = $database->pdo->prepare($sql);
            self::$_sql = $sql;
        }
        $datos = self::$_query->execute($param);
        // ojo!!!: no cerramos conexión
        return $datos;
    }

    public static function removeDB($id){

        $database = medoo::getInstance();
        $database->openConnection(MYSQL_CONFIG);
        $datos = $database->delete('salidas', ['idViaje[=]' => $id]);
        $datos = $datos->rowCount() > 0 ? true : false;
        $database->closeConnection();
        return $datos;

    }

    public static function modifyDB($data, $id) {
        $database = medoo::getInstance();
        $datos = $database->update('salidas', $data, ['idViaje' => $id]);
        return $datos;
    }
}
?>