<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Permissions',
    ['path' => '/permissions'],
    function (RouteBuilder $routes) {
        $routes->connect('/permissions/:controller', ['plugin' => 'Permissions', 'controller' => 'Roles']);
        $routes->fallbacks('DashedRoute');
    }
);

