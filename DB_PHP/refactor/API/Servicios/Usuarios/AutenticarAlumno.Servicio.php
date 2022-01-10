<?php
include_once("Autenticar.Abstract.php");

class AutenticarAlumno extends Autenticar
{
    private array $estrucAutenticar;

    public function __construct(Query $queryObj)
    {
        parent::__construct($queryObj);

        $this->estrucAutenticar = array();
        $this->ArmarEstructura();
    }

    public function ValidarCuenta(array $datosAValidar)
    {
        $this->AutenticarCuentaSICEI($datosAValidar);
        $this->AutenticarCuentaLocal($datosAValidar);
    }


    private function AutenticarCuentaLocal(array $datosCuenta)
    {
        $resultado = $this->queryObj->SELECT($this->estrucAutenticar, $datosCuenta);
    }

    private function AutenticarCuentaSICEI(array $datosCuenta)
    {
    }

    private function ArmarEstructura()
    {
        $datosUsu = array("IDUsuario", "IDRol", "Cuenta");
        $condUsu = array("Cuenta=", "Contraseña=");
        $caracUsu = array("ALIAS" => "USU", "TABLA" => "usuarios", "DESDE" => "si");

        $unionRol = array("UNIR" => "usuarios", "CON" => "IDRol");
        $caracRol = array("ALIAS" => "ROL", "TABLA" => "roles");

        $this->estrucAutenticar["usuarios"] = array("CARAC" => $caracUsu, "DATOS" => $datosUsu, "COND" => $condUsu);
        $this->estrucAutenticar["roles"] = array("CARAC" => $caracRol, "UNIR" => $unionRol);
    }
}
