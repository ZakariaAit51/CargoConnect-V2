<?php
require_once 'core/AltoRouter.php';

$router = new AltoRouter();
$router->setBasePath('/CARGOCONNECT-V2/');

$router->map('GET', '/login', 'User')

?>