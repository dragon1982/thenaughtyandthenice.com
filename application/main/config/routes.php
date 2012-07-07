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

$route['default_controller'] 		= "home";
$route['404_override'] 				= '';

$route['contact']					= 'documents/contact';
$route['documents/2257']			= 'documents/policy_2257';

$route['language/(:any)']			= 'home/language/$1';
$route['reset-password']			= 'home/reset_password';
$route['forgot-password']			= 'home/forgot_password';
$route['activate']					= 'home/activate';

$route['champagne-room']					= 'champagne_room';

$route['logout']					= 'user/logout';
$route['favorites']					= 'user/favorites';
$route['add-favorite/(:any)']		= 'user/add_favorite/$1';
$route['remove-favorite/(:any)']	= 'user/remove_favorite/$1';
$route['settings']					= 'user/settings';
$route['statement']					= 'user/statement';
$route['payments']					= 'user/payments';
$route['newsletter']				= 'user/newsletter';
$route['cancel-account']			= 'user/cancel_account';
$route['tip']						= 'home/tip';
$route['statement/(:any)/(:any)']	= 'user/statement/$1/$2';
$route['payments/(:any)/(:any)']	= 'user/payments/$1/$2';
$route['add-credits']				= 'user/add_credits';
$route['account']					= 'user/index';

$route['(:any)/review']				= 'performers/add_performer_review';

$route['buy-access/(:num)']			= 'user/buy_gallery/$1';
$route['photo/(:num)']				= 'photo/index/$1';

###PERFORMERS###
$route['(performers/page/(:num)|performers/page|performers/page/)']	= 'performers/index';
$route['search/(:any)/page/(:num)']					= 'performers/search/$1/page/$2';
$route['search/(:any)/page/']						= 'performers/search/$1';
$route['search/(:any)/page']						= 'performers/search/$1';
$route['search/(:any)']								= 'performers/search/$1';

$route['room/(:any)']								= 'room/index/$1';




###ADS###

$route['ads/promo/(:any)/(:any)/(:num)/(:num)/(:num)/(:any)/(:any)/(:any)']	= 'ads/promo/$1/$2/$3/$4/$5/$6/$7/$8';
$route['ads/(:any)/(:num)/(:any)']	= 'ads/index/$1/$2/$3';

#################################### FMS ###############################################
$route['translation.php']			= 'fms/translation';
$route['userList.php']				= 'fms/userlist';
$route['userListFull.php']			= 'fms/userlist_performer';

#################################### Videos ###############################################
$route['(videos/page/(:num)|videos/page|videos/page/)']	= 'videos/index';

/* End of file routes.php */
/* Location: ./application/config/routes.php */