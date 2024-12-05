<?php

use cefet\SyncLab\classes\Enviromment;

require __DIR__ . "/../../vendor/autoload.php";

define('ROOT_PATH', realpath(__DIR__ . "/../../"));
define('PUBLIC_PATH', realpath(__DIR__ . '/../'));

if($_SERVER['HTTP_HOST'] == 'synclab.localhost') {
    define('BASE_URL', $_SERVER['HTTP_HOST'] . '/');
}
else
    define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/');


Enviromment::modifyPhpIni();
Enviromment::load(ROOT_PATH);
Enviromment::whoops();








