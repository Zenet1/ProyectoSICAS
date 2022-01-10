<?php
include_once("Autenticar.Abstract.php");

class AutenticarTrabajador extends Autenticar
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
        $this->AutenticarCuentaLocal($datosAValidar);
    }

    private function AutenticarCuentaLocal(array $datosAValidar)
    {
        $resultado = $this->queryObj->SELECT($this->estrucAutenticar, $datosAValidar);
    }

    private function ArmarEstructura()
    {
        $condUsu = array("Cuenta=", "Contraseña=");
        $caracUsu = array("ALIAS" => "USU", "TABLA" => "usuarios", "DESDE" => "si");
        $this->estrucAutenticar["usuarios"] = array("CARAC" => $caracUsu, "COND" => $condUsu);
    }
}
