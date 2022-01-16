<?php

class Roles
{
    private Query $objQuery;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
    }

    public function ObtenerRoles(){
        $sql_SELECTRoles = "SELECT IDRol,Rol FROM roles WHERE IDRol > 1";
        $roles = $this->objQuery->ejecutarConsula($sql_SELECTRoles, array());
        echo json_encode($roles);
    }
}
