<?php
require_once "../include.php";
$idTipo = getPost("idTipo");
echo (Viajes::existeTipo($idTipo))? "si" : "no";
?>