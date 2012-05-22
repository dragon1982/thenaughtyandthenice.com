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

$route['default_controller'] = "home";
$route['404_override'] = '';


$route['statistics']															= 'statistics';

//Admins
$route['admins/delete/(:num)']													= 'admins/delete/$1';
$route['admins/add_or_edit/(:num)']												= 'admins/add_or_edit/$1';
$route['admins/add_or_edit']													= 'admins/add_or_edit';
$route['admins/(:any)']															= 'admins/index/$1';
$route['admins/(:any)/(:any)/(:any)']											= 'admins/index/$1/$2/$3';
$route['admins/(:any)/(:any)/(:any)/(:num)']									= 'admins/index/$1/$2/$3/$4';

//SUPPORTED LANGUAGES
$route['supported_languages/add']												= 'supported_languages/add';
$route['supported_languages/delete/(:num)']										= 'supported_languages/delete/$1';
$route['supported_languages/(:any)']											= 'supported_languages/index/$1';

//Payments
$route['payment-methods/(:any)']												= 'payment_methods/$1';
$route['payment-methods']														= 'payment_methods';


//To Pay
$route['to_pay/']																= 'to_pay/index';
$route['to_pay/update_status']													= 'to_pay/update_status';


$route['music/delete/(:num)']													= 'music/delete/$1';
$route['music/edit/(:num)']														= 'music/edit/$1';
$route['music/add']																= 'music/add';
$route['music/(:any)']															= 'music/index/$1';
$route['music|music/']															= 'music/index';


$route['system_logs/(:any)']													= 'system_logs/index/$1';
$route['system_logs|system_logs/']												= 'system_logs/index';

//Categories
$route['categories/delete/(:num)']												= 'categories/delete/$1';
$route['categories/add_or_edit/(:num)']											= 'categories/add_or_edit/$1';
$route['categories/add_or_edit']												= 'categories/add_or_edit';
$route['categories/write_to_filters']											= 'categories/write_to_filters';
$route['categories/(:any)']														= 'categories/index/$1';
$route['categories/(:any)/(:any)/(:any)']										= 'categories/index/$1/$2/$3';
$route['categories/(:any)/(:any)/(:any)/(:num)']								= 'categories/index/$1/$2/$3/$4';

//Performers
$route['performers/contract_status/(:any)']										= 'performers/contract_status/$1';
$route['performers/contract_status']											= 'performers/contract_status';

$route['performers/photo_status/(:any)']										= 'performers/photo_status/$1';
$route['performers/photo_status']												= 'performers/photo_status';

$route['performers/webcam_status/(:any)']										= 'performers/webcam_status/$1';
$route['performers/webcam_status']												= 'performers/webcam_status';

$route['performers/update_status/(:any)']										= 'performers/update_status/$1';

$route['performers/add_credits']												= 'performers/add_credits';
$route['performers/delete/(:num)']												= 'performers/delete/$1';
$route['performers/account/(:any)']												= 'performers/account/$1';
$route['performers/profile/(:any)']												= 'performers/profile/$1';
$route['performers/photos/(:any)']												= 'performers/photos/$1';
$route['performers/delete_photo/(:any)']										= 'performers/delete_photo/$1';
$route['performers/edit_photo/(:any)']											= 'performers/edit_photo/$1';
$route['performers/edit_video/(:num)']											= 'performers/edit_video/$1';
$route['performers/view_video/(:num)']											= 'performers/view_video/$1';
$route['performers/videos/(:any)']												= 'performers/videos/$1';
$route['performers/sessions/(:any)']											= 'performers/sessions/$1';
$route['performers/payments/(:any)']											= 'performers/payments/$1';
$route['performers/chat_logs/(:any)']											= 'performers/chat_logs/$1';
$route['performers/spy/(:num)']													= 'performers/spy/$1';
$route['performers/(:any)']														= 'performers/index/$1';
$route['performers/(:any)/(:any)/(:any)']										= 'performers/index/$1/$2/$3';
$route['performers/(:any)/(:any)/(:any)/(:num)']								= 'performers/index/$1/$2/$3/$4';

//Studios
$route['studios/contract_status/(:any)']										= 'studios/contract_status/$1';
$route['studios/contract_status']												= 'studios/contract_status';
$route['studios/update_status/(:any)']											= 'studios/update_status/$1';

$route['studios/add_credits']													= 'studios/add_credits';
$route['studios/delete/(:num)']													= 'studios/delete/$1';
$route['studios/account/(:any)']												= 'studios/account/$1';
$route['studios/performers/(:any)']												= 'studios/performers/$1';
$route['studios/payments/(:any)']												= 'studios/payments/$1';
$route['studios/(:any)']														= 'studios/index/$1';
$route['studios/(:any)/(:any)/(:any)']											= 'studios/index/$1/$2/$3';
$route['studios/(:any)/(:any)/(:any)/(:num)']									= 'studios/index/$1/$2/$3/$4';

//Affiliates
$route['affiliates/delete/(:num)']												= 'affiliates/delete/$1';
$route['affiliates/account/(:any)']												= 'affiliates/account/$1';
$route['affiliates/ads/(:any)']													= 'affiliates/ads/$1';
$route['affiliates/payments/(:any)']											= 'affiliates/payments/$1';
$route['affiliates/signups/(:any)']												= 'affiliates/signups/$1';
$route['affiliates/traffic/(:any)']												= 'affiliates/traffic/$1';
$route['affiliates/(:any)']														= 'affiliates/index/$1';
$route['affiliates/(:any)/(:any)/(:any)']										= 'affiliates/index/$1/$2/$3';
$route['affiliates/(:any)/(:any)/(:any)/(:num)']								= 'affiliates/index/$1/$2/$3/$4';

//Users
$route['users/add_credits']														= 'users/add_credits';
$route['users/delete/(:num)']													= 'users/delete/$1';
$route['users/account/(:any)']													= 'users/account/$1';
$route['users/sessions/(:any)']													= 'users/sessions/$1';
$route['users/payments/(:any)']													= 'users/payments/$1';
$route['users/(:any)']															= 'users/index/$1';
$route['users/(:any)/(:any)/(:any)']											= 'users/index/$1/$2/$3';
$route['users/(:any)/(:any)/(:any)/(:num)']										= 'users/index/$1/$2/$3/$4';

//blacklisted
$route['blacklist']																= 'blacklist';


//Newsletter
$route['newsletter/delete/(:num)']												= 'newsletter/delete/$1';
$route['newsletter/account/(:any)']												= 'newsletter/account/$1';
$route['newsletter/(:any)']														= 'newsletter/index/$1';
$route['newsletter/(:any)/(:any)/(:any)']										= 'newsletter/index/$1/$2/$3';
$route['newsletter/(:any)/(:any)/(:any)/(:num)']								= 'newsletter/index/$1/$2/$3/$4';

/* End of file routes.php */
/* Location: ./application/config/routes.php */