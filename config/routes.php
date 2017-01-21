<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Articles', 'action' => 'index']);

    $routes->fallbacks('DashedRoute');
});

Plugin::routes();


// Admin Routes
Router::prefix('painel', function ($routes) {

    $routes->connect('/', ['controller' => 'Dashboard', 'action'=>'index']);

    # USERS
    $routes->connect('/articles', ['controller' => 'Articles', 'action' => 'index']);
    $routes->connect('/articles/view', ['controller' => 'Articles', 'action' => 'view']);
    $routes->connect('/articles/add', ['controller' => 'Articles', 'action' => 'add']);
    $routes->connect('/articles/edit/*', ['controller' => 'Articles', 'action' => 'edit']);
    $routes->connect('/articles/delete/*', ['controller' => 'Articles', 'action' => 'delete']);

    # USERS
      $routes->connect('/users', ['controller' => 'Users', 'action' => 'index']);
      $routes->connect('/users/view', ['controller' => 'Users', 'action' => 'view']);
      $routes->connect('/users/add', ['controller' => 'Users', 'action' => 'add']);
      $routes->connect('/users/edit/*', ['controller' => 'Users', 'action' => 'edit']);
      $routes->connect('/users/delete/*', ['controller' => 'Users', 'action' => 'delete']);
      $routes->connect('/login', ['controller' => 'Users', 'action' => 'login','prefix' => 'painel']);
      $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);


    $routes->fallbacks('InflectedRoute');
});
