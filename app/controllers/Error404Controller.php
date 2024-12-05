<?php

namespace cefet\Adequa\controllers;

class Error404Controller extends Controller
{
    public function processarRequisicao(): void
    {
        http_response_code(404);
    }
}