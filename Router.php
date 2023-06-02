<?php

namespace MVC;

class Router 
{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $funcion)
    {
        $this->rutasGET[$url] = $funcion;
    }

    public function post($url, $funcion)
    {
        $this->rutasPOST[$url] = $funcion;
    }

    public function comprobarRutas() 
    {
        session_start();

        $auth = $_SESSION['login'] ?? null;

        // arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', 
                            '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo =$_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET')
        {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else 
        {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        if(in_array($urlActual, $rutas_protegidas) && !$auth)
        {
            header('location: /');
        }

        if($fn)
        {
            call_user_func($fn, $this);
        } else
        {
            echo "Pagina no encontrada";
        }
    }

    public function render($view, $datos = [])
    {
        foreach($datos as $key => $value)
        {
            $$key = $value;
        }

        ob_start();
        include __DIR__ . "/views/{$view}.php";
        $contenido = ob_get_clean();
        include __DIR__ . '/views/layout.php';
    }

}