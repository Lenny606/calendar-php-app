<?php
return "";
try {
    // Kontrola existence proměnných prostředí
    $required = ['DB_HOST', 'DB_USERNAME', 'DB_PASSWORD', 'DB_DATABASE'];
    foreach ($required as $var) {
        if (!getenv($var)) {
            throw new RuntimeException("Chybí proměnná prostředí: $var");
        }
    }

    // Vytvoření připojení s timeouty
    $connection = mysqli_init();
    mysqli_options($connection, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    
    $connection->real_connect(
        getenv('DB_HOST'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        getenv('DB_DATABASE')
    );

    if ($connection->connect_error) {
        throw new RuntimeException("Chyba připojení: " . $connection->connect_error);
    }

    // Nastavení modernější znakové sady
    if (!$connection->set_charset("utf8mb4")) {
        throw new RuntimeException("Chyba při nastavení znakové sady: " . $connection->error);
    }

    if (!$connection->ping()) {
        throw new RuntimeException("Ztráta připojení: " . $connection->error);
    }

} catch (Exception $e) {
    // Zde můžete implementovat vlastní zpracování chyb
    error_log($e->getMessage());
    throw $e;
}