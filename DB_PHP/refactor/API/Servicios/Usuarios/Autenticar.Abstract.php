<?php

abstract class Autenticar
{
    private Query $queryObj;

    protected function __construct(Query $queryObj)
    {
        $this->queryObj = $queryObj;
    }

    protected abstract function ValidarCuenta(array $datosAValidar);
}
