<?php

namespace cefet\SyncLab\controllers\error;

use cefet\SyncLab\controllers\Controller;

class Error404Controller extends Controller
{
    public function processarRequisicao(): void
    {
        http_response_code(404);
    }
}