<?php
class Autenticar
{
    private Query $queryObj;
    private array $estrucAutenticar;

    public function __construct(Query $queryObj)
    {
        $this->queryObj = $queryObj;
        $this->queryObj = new Query();
        $this->cuentaValida = false;
        $this->estrucAutenticar = array();
        $this->ArmarEstructura();
    }

    public function AutenticarCuenta(array $datosCuenta)
    {
        $this->AutenticarCuentaLocal($datosCuenta);
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

        $datosRol = array("Rol");
        $unionRol = array("UNIR" => "usuarios", "CON" => "IDRol");
        $caracRol = array("ALIAS" => "ROL", "TABLA" => "roles");

        $this->estrucAutenticar["usuarios"] = array("CARAC" => $caracUsu, "DATOS" => $datosUsu, "COND" => $condUsu);
        $this->estrucAutenticar["roles"] = array("CARAC" => $caracRol, "DATOS" => $datosRol, "UNIR" => $unionRol);
    }
}
