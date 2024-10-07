<?php
require '../includes/Database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT id_medico, nombre_medico FROM Medico";

$stmt = $conn->prepare($query);
$stmt->execute();

$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>