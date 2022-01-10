<?php

class Query
{
    private Conexion $conexion;
    private QueryFormatoServicio $formato;

    public function __construct()
    {
        include_once('Conexion.Class.php');
        include_once('QueryFormatoServicio.Class.php');
        $this->formato = new QueryFormatoServicio();
        $this->conexion = Conexion::ConexionInstacia();
    }

    public function SELECT(array $Formato, array $incognitas)
    {
        $resultado = false;
        $queryCompleta = $this->formato->FormatoSELECT($Formato);  
        $resultado = $this->ejecutarConsula($queryCompleta, $incognitas);
        return $resultado;
    }

    public function INSERT(array $Formato, array $incognitas)
    {
        $resultado = false;
        $queryCompleta = $this->formato->FormatoINSERT($Formato);
        $resultado = $this->ejecutarConsula($queryCompleta, $incognitas);
        return $resultado;
    }

    public function UPDATE(array $Formato, array $incognitas)
    {
        $resultado = false;
        $query = $this->formato->FormatoUPDATE($Formato);
        $resultado = $this->ejecutarConsula($query, $incognitas);
        return $resultado;
    }

    public function DELETE(array $Formato, $incognitas)
    {
        $resultado = false;
        $query = $this->formato->FormatoDELETE($Formato);
        $resultado = $this->ejecutarConsula($query, $incognitas);
        return $resultado;
    }

    private function ejecutarConsula(string $queryCompleta, array $variables)
    {
        $objSelect = $this->conexion->getConexion()->prepare($queryCompleta);
        $objSelect->execute($variables);
        return $objSelect->fetchAll(PDO::FETCH_ASSOC);
    }
}
