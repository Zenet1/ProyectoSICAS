<?php

class ReservaQuery
{
    private string $SELECTCuposAct;
    private string $SELECTPorcentaje;

    public function __construct()
    {
        $this->SELECTCuposAct = "SELECT COUNT(RSAL.IDReservaAlumno) AS CR FROM cargaacademica AS CGAC INNER JOIN reservacionesalumnos AS RSAL ON RSAL.IDCarga=CGAC.IDCarga WHERE CGAC.IDGrupo=:idg AND RSAL.FechaReservaAl=:fchR";

        $this->SELECTPorcentaje = "SELECT Porcentaje FROM porcentajecapacidad WHERE IDPorcentaje=1";

    }
}
