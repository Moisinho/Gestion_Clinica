<?php
require_once '../includes/Database.php'; 
require_once '../models/Cita.php'; 


$database = new Database();
$db = $database->getConnection();

$cita = new Cita($db);

$citas = $cita->obtener_citas();
?>