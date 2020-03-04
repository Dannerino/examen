<?php

class ListadoParser
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
                case 'listado':
                    $datos = $_SESSION['datos'];
                    if (count($datos) > 0) {
                        $str = "<table border='1'>
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Tipo</th>
                                        <th>Salida 1</th>
                                        <th>Salida 2</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>";

                        foreach ($datos as $viajes) {
                            $tipo = Viajes::nombreTipo($viajes['idTipo'])[0];
                            $salidas = Viajes::salidas($viajes['id']);
                            $str .= "
                                    <tr>
                                        <td><img src='fotos/" . $viajes['foto'] . "'/></td>
                                        <td>" . $viajes['nombre'] . "</td>
                                        <td>" . $viajes['precio'] . "</td>
                                        <td>" . $tipo . "</td>";
                                        foreach ($salidas as $sal) {
                                            $str .= "<td>" .$sal. "</td>";
                                        }
                                        $str .= "<td colspan=\"4\" style='text-align:center'><a href='?pagina=mensaje&id=" . $viajes['id'] . "'>Descripción</a>  <br> <br> <br><a href='?pagina=eliminacion&opcion=" . $viajes['id'] . "'>Eliminar</a> <br> <br> <br>
                                        <a href='?pagina=edicion&id=" . $viajes['id'] . "'>Modificar</a></td>
                                    </tr>";
                        }
                        $str .= "</table>";

                        Session::del('busqueda');
                    } else
                        $str = '<p> <b>No se han encontrado resultados...</b></p>';
                    break;
            }
            $vista = str_replace('{{' . $tag . '}}', $str, $vista);
        }
        return $vista;
    }
}