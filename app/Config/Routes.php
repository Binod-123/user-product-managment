<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->post('home/save', 'Home::save');
$routes->get('dashboard', 'Home::dashboard');
$routes->get('generate-bill', 'Home::generate_bill');
$routes->get('home/searchProduct', 'Home::searchProduct');
//$routes->resource('products', ['controller' => 'Product']);
//$routes->resource('bills', ['controller' => 'Bill']);
$routes->get('api/bills/user/(:num)', 'BillsController::getBillsByUser/$1');


