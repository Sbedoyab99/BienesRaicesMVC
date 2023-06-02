<?php

namespace Controllers;

use Model\Vendedor;
use MVC\Router;

class VendedorController
{
    public static function crear(Router $router) 
    {
        // Se crea una nueva instancia de vendedor vacia
        $vendedor = new Vendedor;

        // Revisa errores
        $errores = Vendedor::getErrores();

        // Se envia el formulario diligenciado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            // Crea una nueva instanica de propiedad con los campos diligenciados
            $vendedor = new Vendedor($_POST['vendedor']);

            // Valida si hay errores al llenar el formulario
            $errores = $vendedor->validar();

            // Revisar que no hayan errores
            if (empty($errores)) 
            {
                // Guarda la propiedad en la base de datos
                $vendedor->guardar();          
            }
        }

        // Renderiza la pagina
        $router->render('vendedores/crear',[
            'vendedor'=>$vendedor,
            'errores'=>$errores
        ]);
    }

    public static function actualizar(Router $router) 
    {
        // Valida que el id exista
        $id = validarId('/admin');
        
        // Busca en la base de datos la informacion de la propiedad con el id
        $vendedor = Vendedor::find($id);

        // Revisa errores
        $errores = Vendedor::getErrores();

        // Se envia el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            // Revisa la informacion que se introdujo en el formulario
            $args = $_POST['vendedor'];

            // Sincroniza la informacion nueva con la recuperada de la db
            $vendedor->sincronizar($args);

            // Revisar que todos los campos esten completos
            $errores = $vendedor->validar();

            // Revisa que no hayan errores
            if (empty($errores)) 
            {
                // Actualiza el vendedor en la db
                $vendedor->guardar();
            }
        }

        // Renderiza la pagina
        $router->render('/vendedores/actualizar', [
            'vendedor'=>$vendedor,
            'errores'=>$errores,
        ]);
    }

    public static function eliminar() 
    {
        // Se presiona el boton eliminar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            // Recupero el id que se quiere eliminar
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            // Si el id es valido
            if ($id) 
            {
                // Reviso que tipo de elemento se quiere eliminar (propiedad/vendedor)
                $tipo = $_POST['tipo'];

                // Si el tipo es valido
                if (validarTipo($tipo))
                {
                    // Recupero el vendedor que quiero eliminar con el id
                    $vendedor = Vendedor::find($id);

                    // Elimino el vendedor
                    $vendedor->eliminar();
                }
            }
        }
    }
}