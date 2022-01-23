<?php
session_start();
class CuestionarioControl
{
    private CorreoManejador $correo;

    public function __construct(CorreoManejador $correo)
    {
        $this->correo = $correo;
    }

    public function EnviarRechazo(){
        
    }
}
