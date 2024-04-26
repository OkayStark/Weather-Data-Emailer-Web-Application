<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/fetch/(:any)', 'WeatherController::fetchData/$1');
$routes->post('/send-mail', 'WeatherController::sendmail');