<?php

if( ! function_exists('get_avaiable_variabiles') ){
	/**
	 * Returneaza array cu toate variabilele disponibele pt unu din template-ul pentru meiluri
	 *
	 * @param string $template name of file template or FALSE for all variabiles
	 * @param boolean $preg_match if is TRUE prepear variabiles for pragmatch ex: '/{username}/', else '{username}'
	 * 
	 * @return array
	 */
	function get_avaiable_variabiles($template = FALSE, $preg_match = FALSE){
		
		$CI = &get_instance();
	
		list($app, $current_app_folder) = explode('/', APPPATH, 2);
		
		$current_app_folder = substr($current_app_folder, 0, -1);
		
		$variabiles = Array
			(
				'affiliates_forgot_password'				=> array('{username}', '{email}', '{first_name}', '{last_name}', '{affiliate_site_name}', '{affiliate_site_url}', '{reset_password_link}', '{site_url}', '{site_name}'),
				'affiliates_register_pending'			=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}', '{affiliate_site_name}', '{affiliate_site_url}', '{activation_link}', '{site_url}', '{site_name}', '{login_link}'),
				'affiliates_register_welcome'			=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}', '{affiliate_site_name}', '{affiliate_site_url}', '{activation_link}', '{site_url}', '{site_name}', '{login_link}'),
				'main_forgot_password'						=> array('{username}', '{email}', '{reset_password_link}', '{site_url}', '{site_name}'),
				'main_register_pending'					=> array('{username}', '{email}','{password}' , '{activation_link}', '{site_url}', '{site_name}'),
				'main_register_welcome'					=> array('{username}', '{email}','{password}' , '{activation_link}', '{site_url}', '{site_name}'),
				'main_costumer_cancel'						=> array('{username}', '{email}', '{site_url}', '{site_name}'),
				'performers_forgot_password'				=> array('{username}', '{email}', '{reset_password_link}', '{site_url}', '{site_name}'),
				'performers_register_pending'			=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}', '{nickname}', '{activation_link}', '{site_url}', '{site_name}', '{login_link}'),
				'performers_register_welcome'			=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}', '{nickname}', '{activation_link}', '{site_url}', '{site_name}', '{login_link}'),
				'studios_performers_register_pending'	=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}', '{nickname}', '{activation_link}', '{site_url}', '{site_name}', '{login_link}'),
				'studios_performers_register_welcome'	=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}', '{nickname}', '{activation_link}', '{site_url}', '{site_name}', '{login_link}'),		
				'studios_forgot_password'					=> array('{username}', '{email}', '{reset_password_link}', '{site_url}', '{site_name}'),
				'studios_register_pending'				=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}','{activation_link}', '{site_url}', '{site_name}', '{login_link}'),							
				'studios_register_welcome'				=> array('{username}', '{password}', '{email}', '{first_name}', '{last_name}','{activation_link}', '{site_url}', '{site_name}', '{login_link}'),
				'admin_performers_photo_id_rejected'		=> array('{username}', '{email}',  '{first_name}', '{last_name}','{site_url}', '{site_name}', '{login_link}'),
				'admin_performers_photo_id_approved'		=> array('{username}', '{email}',  '{first_name}', '{last_name}','{site_url}', '{site_name}', '{login_link}'),
				'admin_performers_contracts_approved'	=> array('{username}', '{email}',  '{first_name}', '{last_name}','{site_url}', '{site_name}', '{login_link}'),
				'admin_performers_contracts_rejected'	=> array('{username}', '{email}',  '{first_name}', '{last_name}','{site_url}', '{site_name}', '{login_link}'),
				'admin_studio_contracts_rejected'		=> array('{username}', '{email}',  '{first_name}', '{last_name}','{site_url}', '{site_name}', '{login_link}'),
				'admin_studio_contracts_approved'		=> array('{username}', '{email}',  '{first_name}', '{last_name}','{site_url}', '{site_name}', '{login_link}')
				
			);
		
		if($template){
			
			if($current_app_folder != 'admin' && $current_app_folder.'_'.$template != $template){
				$template = $current_app_folder.'_'.$template;
			}
		
			$variabiles = $variabiles[$template];
		}
		
		if($preg_match){
			foreach($variabiles as $key => $var){
				if(is_array($var)){
					if( count($var) > 0){
						foreach($var as $temp_key => $temp_var){
							$variabiles[$key][$temp_key] = '/'.$temp_var.'/';
						}
					}
				}else{
					$variabiles[$key] = '/'.$var.'/';
				}
			}
		}
		
		return $variabiles;
		
	}
}