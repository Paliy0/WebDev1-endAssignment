<?php
require_once('../db.php');
require_once('model/reservation.php')

class ReservationService
{
    private DB $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("select * from reservation");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Reservation');
        $stmt->execute();

        $reservations = $stmt->fetchAll();
        return $reservations;
    }
}
?>