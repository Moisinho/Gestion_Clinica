<?php

class Medicamento
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function obtenermeds()
    {
        $sql = 'SELECT id_medicamento, nombre,cant_stock FROM medicamento;';
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Depuración: Imprimir los datos recuperados


        return $result;
    }
}
