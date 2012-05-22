<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -------------------------------------------------------------------------
if ( ! function_exists('print_amount_by_currency')) {

	/**
	 * Printeaza o suma in currency`ul dat
	 * @param $amount
	 * @param $pay_currency - daca cumva default e setat in virtual currency si avem nevoie sa afisam bani reali gen la listare de credits trebuie pus TRUE
	 * @param $no_transform - nu transforma din chips in currency
	 * @return string
	 */
	function print_amount_by_currency( $amount, $pay_currency = FALSE , $no_transform = FALSE, $nuber_format = TRUE){
		
		if( $pay_currency && SETTINGS_CURRENCY_TYPE ){//daca e cu virtual currency si e si pay currency
			if( $no_transform){
				return SETTINGS_REAL_CURRENCY_SYMBOL . (($nuber_format)? number_format($amount,2): number_format($amount,0));
			} else {
				return SETTINGS_REAL_CURRENCY_SYMBOL . (($nuber_format)? number_format(convert_chips_to_value($amount),2) : number_format(convert_chips_to_value($amount),0));
			}
		}
		if($nuber_format){
			$amount = number_format($amount,2);
		}else{
			$amount = number_format($amount,0);
		}
		
		
		if( SETTINGS_CURRENCY_TYPE ){
			return $amount .' '. SETTINGS_SHOWN_CURRENCY;
		} else {
			return SETTINGS_REAL_CURRENCY_SYMBOL . $amount;				
		}
		
	}

}

// -------------------------------------------------------------------------
if ( ! function_exists('convert_chips_to_value')) {
	
	/**
	 * Converteste chipsuri in valoare
	 * @param unknown_type $chips
	 * @return number
	 * @author Baidoc
	 */
	function convert_chips_to_value($chips){
		return $chips / SETTINGS_CENTS_PER_CREDIT;
	}
}


// -------------------------------------------------------------------------
if ( ! function_exists('convert_value_to_chips')) {
	
	/**
	 * Converteste valoare in chipsuri
	 * @param unknown_type $value
	 * @author Baidoc
	 */
	function convert_value_to_chips($value){
		return $value * SETTINGS_CENTS_PER_CREDIT;
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('get_package_by_amount') ){
	
	/**
	 * Returneaza packetul dupa amount
	 * @param unknown_type $amount
	 * @param unknown_type $packages
	 * @author Baidoc
	 */
	function get_package_by_amount($amount,$packages){
		
		//array gol
		if( sizeof($packages) == 0 ){
			return FALSE;
		}
		
		//cauta packetu
		foreach( $packages as $key => $pack ){
			if( (int) $pack['value'] == $amount ){
				return $pack;
			}
		}
		
		return FALSE;
	}
}