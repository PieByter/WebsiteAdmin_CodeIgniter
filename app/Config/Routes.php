<?php

use CodeIgniter\Router\RouteCollection;
# php -S localhost:8081 -t public
/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth::login');

// $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->view('forbidden', 'errors/forbidden');

// Auth
$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('logout', 'Auth::logout');
});

// Protected routes (perlu login)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');

    // User bisa akses view barang
    $routes->get('barang', 'Barang::index');
    $routes->get('barang/view/(:num)', 'Barang::view/$1');

    $routes->get('event', 'Event::index');
    $routes->post('event/create', 'Event::create');
    $routes->post('event/delete/(:num)', 'Event::delete/$1');
    $routes->post('event/update/(:num)', 'Event::update/$1');
});

// Admin routes
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    // Barang CRUD
    $routes->get('barang', 'Barang::index');
    $routes->get('barang/create', 'Barang::create');
    $routes->post('barang/save', 'Barang::save');
    $routes->get('barang/edit/(:num)', 'Barang::edit/$1');
    $routes->post('barang/update/(:num)', 'Barang::update/$1');
    $routes->get('barang/delete/(:num)', 'Barang::delete/$1');

    // Logs
    $routes->get('logs', 'Log::index');
    $routes->get('logs/filter', 'Log::filter');
    // $routes->post('logs/filter', 'Log::filter');
    $routes->get('logs/export', 'Log::export');
    $routes->get('logs/resetFilter', 'Log::resetFilter');

    // User Management
    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users/save', 'Users::save');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');

    // Settings
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
    $routes->get('settings/backup', 'Settings::backup');
});

// Profile routes
$routes->group('profile', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'Profile::index');
    $routes->get('edit', 'Profile::edit');
    $routes->post('update', 'Profile::update');
});