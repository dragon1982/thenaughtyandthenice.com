<?php
// -------------------------------------------------------------------------
if ( ! function_exists('profile_menu_display'))
{
	
	/**
	 * 
	 * Decide daca e vizibil sau nu tabul din meniu profilului
	 * @author Baidoc
	 */	
	function profile_menu_display(){
		$CI = & get_instance();

		$tabs = array('profile','pictures','videos','schedule','contact');
		
		$CI->input->get('tab');
		
		foreach($tabs as $tab){
			if($tab == $CI->input->get('tab')){	
				$result[$tab] = 1;
			} else {
				$result[$tab] = 0;
			}
		}
		
		if( ! $CI->input->get('tab') ){
			$result['profile'] = 1;
		}
		
		return $result;
	}
}