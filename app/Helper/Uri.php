<?php
namespace cefet\SyncLab\Helper;

class Uri
{
    public static function get(string $type):string
    {
        return parse_url($_SERVER['REQUEST_URI'])[$type];
    }
}
