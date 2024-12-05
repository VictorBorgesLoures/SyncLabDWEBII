<?php
/**
 * @var self::load
 */
return [
    'get' => [
        getenv("DOM_URI") => fn() => self::load('HomeController', 'viewHome'),
        getenv("DOM_URI") . '/contato' => fn() => self::load('HomeController', 'viewContato'),
        getenv("DOM_URI") . '/sobre' => fn() => self::load('HomeController', 'viewSobre'),


    ],

    'post' => [

    ],

    'put' => [


    ],

    'delete' => [

    ],
];