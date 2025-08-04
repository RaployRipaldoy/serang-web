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

// Routes untuk Data Jenis Perlengkapan - Hanya Admin dan Management
$routes->group('', ['filter' => 'adminmanagement'], function ($routes) {
    $routes->get('DataJenisPerlengkapan', 'DataJenisPerlengkapan::index');
    $routes->get('DataJenisPerlengkapan/index', 'DataJenisPerlengkapan::index');
    $routes->get('DataJenisPerlengkapan/create', 'DataJenisPerlengkapan::create');
    $routes->post('DataJenisPerlengkapan/store', 'DataJenisPerlengkapan::store');
    $routes->get('DataJenisPerlengkapan/edit/(:num)', 'DataJenisPerlengkapan::edit/$1');
    $routes->post('DataJenisPerlengkapan/update/(:num)', 'DataJenisPerlengkapan::update/$1');
    $routes->get('DataJenisPerlengkapan/delete/(:num)', 'DataJenisPerlengkapan::delete/$1');
    $routes->get('DataJenisPerlengkapan/detail/(:num)', 'DataJenisPerlengkapan::detail/$1');
});
