<?php
class Oficina
{
    private Conexion $conexion;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        //include_once('Conexion.Class.php');
        //$this->conexion = Conexion::ConexionInstacia();
    }

    public function recuperarOficinas()
    {
        $sql_obtenerOficinas = "SELECT OFC.NombreOficina, OFC.Departamento, EDF.NombreEdificio, OFC.IDOficina
        FROM oficinas AS OFC
        INNER JOIN edificios AS EDF
        ON EDF.IDEdificio=OFC.IDEdificio";

        $obj_obtenerOficinas = $this->conexion->getConexion()->prepare($sql_obtenerOficinas);
        $obj_obtenerOficinas->execute();
        $oficinasRecuperadas = $obj_obtenerOficinas->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($oficinasRecuperadas);
    }
    
    public function eliminarOficina($id)
    {   
        $sql_eliminarOficina = "DELETE FROM oficinas WHERE IDOficina = ?";
        $obj_eliminarOficina = $this->conexion->getConexion()->prepare($sql_eliminarOficina);
        $obj_eliminarOficina->execute(array($id));
    }
    
    function insertarOficina(array $oficina)
    {

        $sql_recuperarIDEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio = ?";
        $obj_recuperarIDEdificio =$this->conexion->getConexion()->prepare($sql_recuperarIDEdificio);
        $obj_recuperarIDEdificio->execute(array($oficina["edificio"]));
        $IDEdificio = $obj_recuperarIDEdificio->fetch(PDO::FETCH_ASSOC);
        
        if($this->validarOficinaRegistrada($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"])){
            
            $sql_insertarOficina = "INSERT INTO oficinas (NombreOficina, Departamento, IDEdificio) SELECT ?, ?, ? FROM DUAL
            WHERE NOT EXISTS (SELECT NombreOficina, Departamento, IDEdificio FROM oficinas WHERE NombreOficina = ? AND Departamento = ? AND IDEdificio = ?) LIMIT 1";
            
            $obj_insertarOficina = $this->conexion->getConexion()->prepare($sql_insertarOficina);
            
            if (isset($IDEdificio["IDEdificio"])) {
                $obj_insertarOficina->execute(array($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"], $oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"]));
            }
        }
    }
    
    function validarOficinaRegistrada(string $nombreOficina, string $departamento, string $IDEdificio) : bool
    {
        $sql_validarOficina = "SELECT * FROM oficinas WHERE NombreOficina = ? AND Departamento = ? AND IDEdificio = ?";
        $obj_validarOficina = $this->conexion->getConexion()->prepare($sql_validarOficina);
        $obj_validarOficina->execute(array($nombreOficina, $departamento, $IDEdificio));
        $oficinaDevuelta = $obj_validarOficina->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$this->validarVariable($oficinaDevuelta)){
            echo "ERROR: Oficina duplicada";
            return false;
        }
        return true;
    }

    function validarVariable(array $variable) : bool{
        return ($variable === false || sizeof($variable) === 0);
    }
}

?>