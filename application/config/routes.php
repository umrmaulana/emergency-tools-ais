<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Authentication routes
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Emergency Tools routes
$route['emergency-tools'] = 'emergency_tools/dashboard';
$route['emergency-tools/dashboard'] = 'emergency_tools/dashboard';
$route['emergency-tools/report'] = 'emergency_tools/report';
$route['emergency-tools/equipment'] = 'emergency_tools/equipment';
$route['emergency-tools/master-location'] = 'emergency_tools/master_location';
$route['emergency-tools/master-equipment'] = 'emergency_tools/master_equipment';
$route['emergency-tools/master-checksheet'] = 'emergency_tools/master_checksheet';

// Master Location routes (working)
$route['location'] = 'emergency_tools/master_location/debug';
$route['location/debug'] = 'emergency_tools/master_location/debug';
$route['location/index'] = 'emergency_tools/master_location/index';
$route['location/create'] = 'emergency_tools/master_location/create';
$route['location/edit/(:num)'] = 'emergency_tools/master_location/edit/$1';
$route['location/api/(:any)'] = 'emergency_tools/master_location/api/$1';
$route['location/api/(:any)/(:num)'] = 'emergency_tools/master_location/api/$1/$2';
