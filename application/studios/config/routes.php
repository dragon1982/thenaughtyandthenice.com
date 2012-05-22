<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 									= "home";
$route['404_override'] 											= '';

$route['earnings']												= 'home/earnings';
$route['earnings-detail/(:any)'] 								= "home/earnings_detail/$1";
$route['earnings/(:any)'] 										= "home/earnings/$1";

$route['payments']												= 'home/payments';
$route['payments/(:any)'] 										= "home/payments/$1";
$route['settings/personal-details'] 							= "settings/personal_details";
$route['payment-details/(:num)']								= 'home/payment_details/$1';

$route['performer/add-photo-id/(:num)']							= 'performers/add_photo_id/$1';
$route['performer/add-contract/(:num)']							= 'performers/add_contract/$1';

$route['performer/(:num)']										= "performer/home/index/$1";
$route['performer/settings/personal-details'] 					= "performer/settings/personal_details";
$route['performer/my_payments']									= "performer/home/payments";
$route['performer/my_earnings']									= "performer/home/earnings";
$route['performer/my_payments/(:any)']							= "performer/home/payments/$1";
$route['performer/my_earnings/(:any)']							= "performer/home/earnings/$1";
$route['performer/settings/banned-zones'] 						= "performer/settings/banned_zones";

$route['contact']												= 'home/contact';
$route['logout']												= 'home/logout';

#################################### FMS ###############################################
$route['translation.php']			= 'fms/translation';
$route['userList.php']				= 'fms/userlist';
$route['userListFull.php']			= 'fms/userlist_performer';

/* End of file routes.php */
/* Location: ./application/config/routes.php */