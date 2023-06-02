<?php

namespace Controllers;

use Model\Admin;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if(empty($errores))
            {
                // Verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                if(!$resultado)
                {
                    $errores = Admin::getErrores();
                } else {
                    // Verificar si el password es correcto
                    $autenticado = $auth->comprobarPassword($resultado);

                    if($autenticado)
                    {
                        // Autenticar el usuario
                        $auth->autenticar();
                    } else {
                        $errores = Admin::getErrores();
                    }
                }
            }
        }

        $router->render('auth/login',[
            'errores' => $errores
        ]);
    }

    public static function logout()
    {
        session_start();

        $_SESSION = [];

        header('location: /login');
    }
}