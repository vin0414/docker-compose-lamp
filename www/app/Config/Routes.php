<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//authentication
$routes->post('/auth','Auth::auth');
$routes->get('/logout','Auth::logout');
//user management
$routes->post('/save-account','Home::saveAccount');
$routes->post('/update-account','Home::updateAccount');
$routes->post('/deactivate','Home::deactivateAccount');
$routes->post('/activate','Home::activateAccount');
$routes->post('/reset','Home::reset');
$routes->get('/search-account','Home::searchAccount');
//branch,region,zone
$routes->get('/fetch-zones','Home::fetchZones');
$routes->get('/search-zones','Home::searchZones');
$routes->post('/save-zone','Home::saveZone');
$routes->post('/delete-zone','Home::deleteZone');
$routes->get('/fetch-regions','Home::fetchRegions');
$routes->get('/search-regions','Home::searchRegions');
$routes->post('/save-region','Home::saveRegion');
$routes->post('/delete-region','Home::deleteRegion');
$routes->get('/list-of-regions','Home::listRegions');
$routes->get('/fetch-branches','Home::fetchBranches');
$routes->get('/search-branches','Home::searchBranches');
$routes->post('/save-branch','Home::saveBranch');
$routes->post('/delete-branch','Home::deleteBranch');
$routes->post('/update-branch','Home::updateBranch');

$routes->group('',['filter'=>'AuthCheck'],function($routes)
{
    $routes->get('/dashboard','Home::dashboard');
    $routes->get('/reports','Home::report');
    $routes->get('/branch-report','Home::branchReport');
    $routes->get('/users','Home::users');
    $routes->get('/new-account','Home::newAccount');
    $routes->get('/edit-account/(:any)','Home::editAccount/$1');
    $routes->get('/zones','Home::zone');
    $routes->get('/regions','Home::region');
    $routes->get('/branches','Home::branch');
    $routes->get('/edit-branch/(:any)','Home::editBranch/$1');
    $routes->get('/upload','Home::uploadFile');
});

$routes->group('',['filter'=>'AlreadyLoggedIn'],function($routes)
{
    $routes->get('/', 'Home::index');
});
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
