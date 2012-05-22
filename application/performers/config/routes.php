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

$route['default_controller'] 						= 'home';
$route['logout']									= 'home/logout';
$route['my_payments']								= 'home/payments';
$route['my_payments/(:any)']						= 'home/payments/$1';
$route['my_earnings']								= 'home/earnings';
$route['my_earnings/(:any)']						= 'home/earnings/$1';
$route['my_payments/statements']					= 'home/earnings';

$route['payment-details/(:num)']					= 'home/payment_details/$1';

$route['broadcast']									= 'home/broadcast';
$route['live|live/(:any)']							= 'home/live';
$route['settings/personal-details']					= 'settings/personal_details';
$route['settings/add-contract']						= 'settings/add_contract';

$route['videos/page/(:any)|videos/page']			= 'videos/index';


$route['settings/set-payment-details/(:any)']		= 'settings/set_payment_details/$1';
$route['settings/edit-payment-details']				= 'settings/edit_payment_details';
$route['mp3.php']									= 'fms/mp3';

$route['fmle']									= 'home/fmle';
$route['changeNude.php']						= 'fms/change_nude';
$route['changePeek.php']						= 'fms/change_peek';

$route['404_override'] 								= '';
/* End of file routes.php */
/* Location: ./application/config/routes.php */