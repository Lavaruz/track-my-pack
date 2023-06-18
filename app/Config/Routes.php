<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/logout', 'LoginController::logout');
$routes->post('/verify', 'LoginController::auth');
$routes->post('/getAllDashboard', 'Home::getAllDashboard');
$routes->post('/cekPengirimanResi', 'PengirimanController::getDetailByResi');

// Pengiriman
$routes->get('/pengiriman', 'PengirimanController::index');
$routes->get('/pengiriman/tambah', 'PengirimanController::form/add');
$routes->get('/pengiriman/edit/(:segment)', 'PengirimanController::form/update/$1');
$routes->get('/pengiriman/view/(:segment)', 'PengirimanController::form/view/$1');
$routes->get('/pengiriman/hapus/(:num)', 'PengirimanController::do_delete/$1');
$routes->post('/pengiriman/getAllDashboard', 'PengirimanController::getAllDashboard');
$routes->post('/pengiriman/tambah', 'PengirimanController::do_add');
$routes->post('/pengiriman/edit/(:num)', 'PengirimanController::form/do_update/$1');

// Perusahaan
$routes->get('/perusahaan', 'PerusahaanController::index');
$routes->get('/perusahaan/tambah', 'PerusahaanController::form/add');
$routes->get('/perusahaan/edit/(:num)', 'PerusahaanController::form/update/$1');
$routes->get('/perusahaan/view/(:num)', 'PerusahaanController::form/view/$1');
$routes->get('/perusahaan/hapus/(:num)', 'PerusahaanController::do_delete/$1');
$routes->post('/perusahaan/getAllDashboard', 'PerusahaanController::getAllDashboard');
$routes->post('/perusahaan/tambah', 'PerusahaanController::do_add');
$routes->post('/perusahaan/edit/(:num)', 'PerusahaanController::do_update/$1');

// User
$routes->get('/user', 'UserController::index');
$routes->get('/user/tambah', 'UserController::form/add');
$routes->get('/user/edit/(:num)', 'UserController::form/edit/$1');
$routes->get('/user/view/(:num)', 'UserController::form/view/$1');
$routes->get('/user/hapus/(:num)', 'UserController::do_delete/$1');
$routes->post('/user/getAllDashboard', 'UserController::getAllDashboard');
$routes->post('/user/tambah', 'UserController::do_add');
$routes->post('/user/edit/(:num)', 'UserController::do_update/$1');


// Language API
$routes->get('/setLanguage/(:segment)', 'ApiController::setLanguage/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
