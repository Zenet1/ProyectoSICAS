<?php
class Oficina
{
    private Query $objQuery;

    public function __construct(Query $objQuery)
    {
    }

    public function recuperarOficinas()
    {
        $sql_obtenerOficinas = "SELECT OFC.NombreOficina, OFC.Departamento, EDF.NombreEdificio, OFC.IDOficina FROM oficinas AS OFC INNER JOIN edificios AS EDF ON EDF.IDEdificio=OFC.IDEdificio";

        $oficinasRecuperadas = $this->objQuery->ejecutarConsula($sql_obtenerOficinas, array());
        echo json_encode($oficinasRecuperadas);
    }

    public function eliminarOficina(array $contenido)
    {  
        print_r($contenido);
        $sql_eliminarOficina = "DELETE FROM oficinas WHERE IDOficina = ?";
        $this->objQuery->ejecutarConsula($sql_eliminarOficina, array($contenido[""]));
    }
 /*   
    function insertarOficina($datosOficina)
    {
        $nombreOficina = $datosOficina->oficina;
        $departamentoOficina = $datosOficina->departamento;
        $edificioOficina = $datosOficina->edificio;

        $sql_recuperarIDEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio = ?";
        $obj_recuperarIDEdificio =$this->conexion->getConexion()->prepare($sql_recuperarIDEdificio);
        $obj_recuperarIDEdificio->execute(array($edificioOficina));
        $IDEdificio = $obj_recuperarIDEdificio->fetch(PDO::FETCH_ASSOC);
        
        if($this->validarOficinaRegistrada($nombreOficina, $departamentoOficina, $IDEdificio["IDEdificio"])){
            
            $sql_insertarOficina = "INSERT INTO oficinas (NombreOficina, Departamento, IDEdificio) SELECT ?, ?, ? FROM DUAL
            WHERE NOT EXISTS (SELECT NombreOficina, Departamento, IDEdificio FROM oficinas WHERE NombreOficina = ? AND Departamento = ? AND IDEdificio = ?) LIMIT 1";

            $obj_insertarOficina = $this->conexion->getConexion()->prepare($sql_insertarOficina);

            if (isset($IDEdificio["IDEdificio"])) {
                $incognitas = array($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"], $oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"]);
                $this->objQuery->ejecutarConsula($sql_insertarOficina, $incognitas);
            }
        }
    }

    function validarOficinaRegistrada(string $nombreOficina, string $departamento, string $IDEdificio): bool
    {
        $sql_validarOficina = "SELECT * FROM oficinas WHERE NombreOficina = ? AND Departamento = ? AND IDEdificio = ?";
        $obj_validarOficina = $this->conexion->getConexion()->prepare($sql_validarOficina);
        $obj_validarOficina->execute(array($nombreOficina, $departamento, $IDEdificio));
        $oficinaDevuelta = $obj_validarOficina->fetchAll(PDO::FETCH_ASSOC);

        if (!$this->validarVariable($oficinaDevuelta)) {
            echo "ERROR: Oficina duplicada";
            return false;
        }
        return true;
    }

    function validarVariable(array $variable): bool
    {
        return ($variable === false || sizeof($variable) === 0);
    }
    */
}
