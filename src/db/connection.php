|<?php

$connection = new mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv("DB_DATABASE"));

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$connection->set_charset("utf8");

if (!$connection->ping()) {
    die("Connection lost: " . $connection->error);
}
