<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// CRUD Employés

$routes->get('/employees', 'EmployeeController::index');
$routes->get('/employees/new', 'EmployeeController::new');
$routes->post('/employees/create', 'EmployeeController::create');
$routes->get('/employees/edit/(:num)', 'EmployeeController::edit/$1');
$routes->post('/employees/update/(:num)', 'EmployeeController::update/$1');
$routes->get('/employees/delete/(:num)', 'EmployeeController::delete/$1');