<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->get('callback', 'Auth::callback');
$routes->get('logout', 'Auth::logout');
$routes->get('token', 'Auth::token');
$routes->get('launch/(:segment)', 'Auth::launch/$1');

$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->post('add', 'Admin::add');
    $routes->get('delete/(:any)', 'Admin::delete/$1');
});

