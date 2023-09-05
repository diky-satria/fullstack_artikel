<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/artikel', 'ArtikelController::index');
$routes->get('/artikel/(:num)', 'ArtikelController::show/$1');
$routes->post('/artikel', 'ArtikelController::create');
$routes->post('/artikel/(:num)', 'ArtikelController::update/$1');
$routes->post('/artikel/hapus/(:num)', 'ArtikelController::delete/$1');

$routes->get('/artikel/home', 'ArtikelController::home');
$routes->get('/artikel/home/(:num)', 'ArtikelController::show_home/$1');
