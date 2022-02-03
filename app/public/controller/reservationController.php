<?php
require_once('service/ReservationService.php');

class reservationController {

    private ReservationController $service;

    public function __construct() {
        $this->service = new ReservationService();
    }
    public function index() {
        $reservations = $this->service->getAll();
        include_once('views/reservations.php');
    }
}