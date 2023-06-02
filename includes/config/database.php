<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '1039475784', 'BienesRaices_CRUD');
    $db->set_charset('utf8');
    if (!$db) {
        echo"Error: no se pudo conectar";
        exit;
    }

    return $db;
}