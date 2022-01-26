<?php

class ReservaQuery
{
    private string $INSERTReserva;
    private string $SELECTIDReserva;

    public function __construct()
    {
        $this->INSERTReserva = "INSERT INTO reservacionespersonal (FechaReserva,HoraActual,FechaActual,IDPersonalRes) SELECT :fchR,:hrA,:fchA,:idp FROM DUAL WHERE NOT EXISTS (SELECT IDPersonalRes,FechaReserva FROM reservacionespersonal WHERE IDPersonalRes=:idp AND FechaReserva=:fchR) LIMIT 1";

        $this->SELECTIDReserva = "SELECT IDReservaPersonal FROM reservacionespersonal WHERE IDPersonalRes=:idp AND FechaReserva=:fchR";
    }

    public function InsertarReserva(): string
    {
        return $this->INSERTReserva;
    }

    public function RecuperarID(): string
    {
        return $this->SELECTIDReserva;
    }
}
