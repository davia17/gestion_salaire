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

// CRUD Salaires
$routes->get('/salaries', 'SalaryController::index');
$routes->get('/salaries/new', 'SalaryController::new');
$routes->post('/salaries/create', 'SalaryController::create');
$routes->get('/salaries/edit/(:num)', 'SalaryController::edit/$1');
$routes->post('/salaries/update/(:num)', 'SalaryController::update/$1');
$routes->get('/salaries/delete/(:num)', 'SalaryController::delete/$1');