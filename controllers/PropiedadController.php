<?php

namespace Controllers;

use Model\Propiedad;
use Model\Vendedor;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    public static function index(Router $router)
    {
        // Busca las propiedades en la base de datos
        $propiedades = Propiedad::all();

        // Busca los vendedores en la base de datos
        $vendedores = Vendedor::all();

        // Verifica si hay mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        // Renderiza la pagina
        $router->render('propiedades/admin',[
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router)
    {   
        // Crea una instancia de propiedad vacia
        $propiedad = new Propiedad;

        // Busca los vendedores en la base de datos
        $vendedores = Vendedor::all();

        // Verifica si hay errores en el formulario
        $errores = Propiedad::getErrores();

        // Cuando se da submit en el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            // Crea una nueva instanica de propiedad con los campos diligenciados
            $propiedad = new Propiedad($_POST['propiedad']);

            // Hashear el name de la imagen con un name unico
            $nombreImagen = md5(uniqid(rand(), true)).".jpg";

            // Setea la imagen
            if($_FILES['propiedad']['tmp_name']['imagen'])
            {   
                // Redimensiona y crea la imaen con la informacion de $_files
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                // Nombra la imagen
                $propiedad->setImagen($nombreImagen);
            }

            // Valida si hay errores al llenar el formulario
            $errores = $propiedad->validar();

            // Revisar que no hayan errores
            if (empty($errores)) 
            {
                // Verificar si la carpeta de imagenes existe, si no existe crearla
                if(!is_dir(CARPETA_IMAGENES))
                {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guarda la imagen en la carpeta imagenes
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guarda la propiedad en la base de datos
                $propiedad->guardar();          
            }
        }

        $router->render('propiedades/crear',[
            'propiedad'=> $propiedad,
            'vendedores'=>$vendedores,
            'errores'=>$errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        // Valida que el id exista
        $id = validarId('/admin');
        
        // Busca en la base de datos la informacion de la propiedad con el id
        $propiedad = Propiedad::find($id);

        // Verifica si hay errores en el formulario
        $errores = Propiedad::getErrores();

        // Busca los vendedores en la base de datos 
        $vendedores = Vendedor::all();

        // Se da submit al formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            // Revisa la informacion que se introdujo en el formulario
            $args = $_POST['propiedad'];

            // Sincroniza la informacion nueva con la recuperada de la db
            $propiedad->sincronizar($args);

            // Revisar que todos los campos esten completos
            $errores = $propiedad->validar();

            // Hashear el name de la imagen con un name unico
            $nombreImagen = md5(uniqid(rand(), true)).".jpg";

            // Revisa si hay una imagen nueva
            if($_FILES['propiedad']['tmp_name']['imagen'])
            {
                // Redimenciona y crea la imagen con la informacion de $_files
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);

                // Nombra la imagen
                $propiedad->setImagen($nombreImagen);
            }

            // Revisa que no hayan errores
            if (empty($errores)) 
            {
                // Revisa si hay una imagen nueva
                if ($_FILES['propiedad']['tmp_name']['imagen'])
                {
                    // Guarda la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                // Actualiza la propiedad en la db
                $propiedad->guardar();
            }
        }

        // Renderiza la pagina
        $router->render('/propiedades/actualizar', [
            'propiedad'=>$propiedad,
            'errores'=>$errores,
            'vendedores'=>$vendedores
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
                    // Recupero la propiedad que quiero eliminar con el id
                    $propiedad = Propiedad::find($id);

                    // Elimino la propiedad
                    $propiedad->eliminar();
                }
            }
        }
    }
}