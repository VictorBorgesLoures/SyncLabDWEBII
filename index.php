<?php

session_start();

use cefet\Adequa\classes\Enviromment;
use cefet\Adequa\router\Router;

require __DIR__ . '/public/bootstrap/ini.php';

Router::execute();


\cefet\Adequa\classes\Session::removeFlash();