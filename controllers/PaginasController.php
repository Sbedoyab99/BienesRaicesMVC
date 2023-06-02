<?php

namespace Controllers;

use Model\Propiedad;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades',[
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        $id = validarId('/propiedades');

        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad',[
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }

    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router)
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $phpmailer = new PHPMailer();

            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '569626f2581e86';
            $phpmailer->Password = 'cf53632763dc49';
            $phpmailer->SMTPSecure = 'tls';
            $phpmailer->setFrom('admin@bienesraices.com');
            $phpmailer->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $phpmailer->Subject = 'Tienes un nuevo mensaje';
            $phpmailer->isHTML(true);
            $phpmailer->CharSet = 'UTF-8';

            $contenido = '<html><p>Tienes un nuevo mensaje</p></html>';
            $phpmailer->Body = $contenido;
            $phpmailer->AltBody = 'Texto alternativo';

            if($phpmailer->send())
            {
                echo 'mensaje enviado';
            }   else {
                echo 'mensaje no enviado';
            }

        }

        $router->render('paginas/contacto');
    }  
}