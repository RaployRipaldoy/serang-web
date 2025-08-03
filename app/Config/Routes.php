<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//for auth middleware / filter
// $routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('DataPengadaan/getPengadaanByPerlengkapanAjax', 'DataPengadaan::getPengadaanByPerlengkapan');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    // $routes->get('/', 'BaseController::index');
    $routes->get('DataPerlengkapan/index', 'DataPerlengkapan::index');
    $routes->get('DataPerlengkapan/inputPerlengkapan', 'DataPerlengkapan::inputPerlengkapan');

});
