<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::dashboard');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->post('home/save', 'Home::save');
$routes->get('dashboard', 'Home::dashboard');
$routes->get('generate-bill', 'Home::generate_bill');
$routes->get('home/searchProduct', 'Home::searchProduct');
$routes->get('/logout', 'Auth::logout');
$routes->get('api/bills/details/(:any)', 'BillsController::getBillDetails/$1');
$routes->get('api/bills/user/(:num)', 'BillsController::getBillsByUser/$1');


