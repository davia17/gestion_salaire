<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

// CRUD EMPLOYÉS
$routes->get('/employes', 'EmployeController::index');
$routes->get('/employes/new', 'EmployeController::new');
$routes->post('/employes/create', 'EmployeController::create');
$routes->get('/employes/edit/(:segment)', 'EmployeController::edit/$1');
$routes->post('/employes/update/(:segment)', 'EmployeController::update/$1');
$routes->get('/employes/delete/(:segment)', 'EmployeController::delete/$1');

// CRUD POSTES
$routes->get('/postes', 'PosteController::index');
$routes->get('/postes/new', 'PosteController::new');
$routes->post('/postes/create', 'PosteController::create');
$routes->get('/postes/edit/(:num)', 'PosteController::edit/$1');
$routes->post('/postes/update/(:num)', 'PosteController::update/$1');
$routes->get('/postes/delete/(:num)', 'PosteController::delete/$1');
