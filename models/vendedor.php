<?php

namespace Model;

class Vendedor extends ActiveRecord
{
    protected static $tabla = "vendedores";
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args =[])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() 
    {
        // Validacion de la informacion

        if (!$this->nombre) 
        {
            self::$errores [] = "El Nombre es obligatorio";
        }
        if (!$this->apellido) 
        {
            self::$errores [] = "El Apellido es obligatorio";
        }
        if(!preg_match('/[0-9]{10}/', $this->telefono) or strlen($this->telefono) != 10)
        {
            if (!$this->telefono) 
            {
                self::$errores [] = "El telefono es obligatoria";
            } else {
                self::$errores [] = "El Formato de telefono no es valido";
            }
        }

        return self::$errores;
    }
}