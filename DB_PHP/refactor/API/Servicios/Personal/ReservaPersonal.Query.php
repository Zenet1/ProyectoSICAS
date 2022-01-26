<?php

class ReservaQuery
{
    private string $INSERTReservaPer;
    private string $INSERTReservaPro;
    private string $SELECTIDReserva;

    public function __construct()
    {
        $this->INSERTReservaPer = "INSERT INTO reservacionespersonal (FechaReserva,HoraActual,FechaActual,IDPersonalRes) SELECT :fchR,:hrA,:fchA,:idp FROM DUAL WHERE NOT EXISTS (SELECT IDPersonalRes,FechaReserva FROM reservacionespersonal WHERE IDPersonalRes=:idp AND FechaReserva=:fchR) LIMIT 1";

        $this->INSERTReservaPro = "INSERT INTO reservacionesacademicos (FechaReserva,HoraActual,FechaActual,IDPersonalRes) SELECT :fchR,:hrA,:fchA,:idp FROM DUAL WHERE NOT EXISTS (SELECT IDPersonalRes,FechaReserva FROM reservacionespersonal WHERE IDPersonalRes=:idp AND FechaReserva=:fchR) LIMIT 1";

    }

    public function InsertarReservaPer(): string
    {
        return $this->INSERTReservaPer;
    }

    public function InsertarReservaPro(): string
    {
        return $this->INSERTReservaPro;
    }

    public function RecuperarID(string $tabla): string
    {
        return "SELECT IDReservaPersonal FROM $tabla WHERE IDPersonalRes=:idp AND FechaReserva=:fchR";
    }
}
