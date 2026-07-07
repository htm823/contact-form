<?php

return [
    'host'     => $_ENV['DB_HOST'],
    'port'     => (int) $_ENV['DB_PORT'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset'  => 'utf8mb4',
];