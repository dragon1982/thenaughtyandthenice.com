<?php
/**
 * @TUTORIAL: 
 * 		'age' -> numele filtrului
 * 		lang(age) -> cum ar trebui gasit in Pagina - diferit de la limba la limba
 * 						-> acesta are optiuni lang('age_18_22') cum se gaseste in pagina, iar valoarea lui se gaseste in URL
 * 		Se genereaza la install
 */

#hardcodat
/*$config['filters']['age_range'] = array(lang('age_range') => array (
										lang('age_18_22')	=> '18-22',
										lang('age_23_27')	=> '23-27',
										lang('age_23_27')	=> '28-32',
										lang('age_23_27')	=> '33-37',
										lang('age_38_42')	=> '38-42'								
									)
							);*/
require_once 'filters_from_enums.php';
require_once 'categories.php';