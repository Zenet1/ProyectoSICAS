<?php
class AlumnoControl
{
    private Query $objQuery;
    private Fechas $objFecha;

    public function __construct(Query $objQuery, Fechas $objFecha)
    {
        $this->objQuery = $objQuery;
        $this->objFecha = $objFecha;
    }

    public function EnviarQRCorreo()
    {
    }

    private function GenerarQRAlumno()
    {
        $IDReservaAlumno = "SELECT RSV.IDReservaAlumno FROM reservacionesalumnos AS RSV INNER JOIN cargaacademica AS CGAC ON RSV.IDCarga=CGAC.IDCarga WHERE CGAC.IDAlumno=:ida AND RSV.FechaAlumno=:fchA";
        
        

        $this->objQuery->ejecutarConsulta($IDReservaAlumno, array());

    }
}
