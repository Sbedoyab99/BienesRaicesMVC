<?php

namespace Model;

class Propiedad extends ActiveRecord
{
    protected static $tabla = "propiedades";
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones',
    'baños', 'estacionamiento', 'creado', 'vendedorid'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $baños;
    public $estacionamiento;
    public $creado;
    public $vendedorid;

    public function __construct($args =[])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->baños = $args['baños'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorid = $args['vendedorid'] ?? '';
    }

    public function validar() 
    {
        // Validacion de la informacion

        if (!$this->titulo) 
        {
            self::$errores [] = "El titulo es obligatorio";
        }
        if (!$this->precio) 
        {
            self::$errores [] = "El precio es obligatorio";
        }
        if (!$this->descripcion) 
        {
            self::$errores [] = "La descripcion es obligatoria";
        }
        if (strlen($this->descripcion) < 50) 
        {
            self::$errores[] = "La descripcion debe tener al menos 50 caracteres";
        }
        if (!$this->habitaciones) 
        {
            self::$errores [] = "El numero de habitaciones es obligatorio";
        }
        if (!$this->baños) 
        {
            self::$errores [] = "El numero de baños es obligatorio";
        }
        if (!$this->estacionamiento) 
        {
            self::$errores [] = "El numero de estacionamientos es obligatorio";
        }
        if (!$this->vendedorid) 
        {
            self::$errores [] = "Debes seleccionar un vendedor";
        }
        if (!$this->imagen) 
        {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
}