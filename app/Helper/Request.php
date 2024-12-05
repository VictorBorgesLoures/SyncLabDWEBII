<?php
namespace cefet\Adequa\Helper;

class Request
{
    public static function get():string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
