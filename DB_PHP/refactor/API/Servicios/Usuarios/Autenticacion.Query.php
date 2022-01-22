<?php

class AutentcacionQuery
{
    private string $SELECTVerificar;
    private string $SELECTAlumno;

    public function __construct()
    {
        $this->SELECTVerificar = "SELECT us.IDUsuario,us.IDRol,us.Cuenta,ro.IDRol,ro.Rol FROM usuarios AS us INNER JOIN roles AS ro ON ro.IDRol=us.IDRol WHERE us.Cuenta=:ctn AND us.Contraseña=:pss";

        $this->SELECTAlumno = "SELECT IDAlumno,NombreAlumno,ApellidoPaternoAlumno,ApellidoMaternoAlumno,Matricula,CorreoAlumno FROM alumnos WHERE IDUsuario=:idu";
    }

    public function VerificarLocal(): string
    {
        return $this->SELECTVerificar;
    }

    public function DatosAlumno(): string
    {
        return $this->SELECTAlumno;
    }
}
