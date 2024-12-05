<?php

session_start();

use cefet\SyncLab\classes\Enviromment;
use cefet\SyncLab\router\Router;

require __DIR__ . '/public/bootstrap/ini.php';

Router::execute();


\cefet\SyncLab\classes\Session::removeFlash();