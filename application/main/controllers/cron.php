<?php
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $firephp
 * @property CI_DB_active_record $db
 * @property Users $users
 * @property Categories $categories
 * @property Performers $performers
 * @property Watchers $watchers
 * @property System_logs $system_logs
 * @property Payment_methods $payment_methods
 * @property Fms $fms
 * @property Payments $payments
 * @property Studios $studios
 * @property affiliates $affiliates
 * @property ad_traffic $ad_traffic
 * @property performers_ping $performers_ping
 */

class Cron_controller extends CI_Controller{
	
	/**
	 * Constructor
	 * @author Baidoc
	 */
	function __construct(){
		
		parent::__construct();
		
		//ACCESS TO THIS AREEA IS RESTRICTED TO CLIENT ONLY
		$hash = $this->input->get('key'); 
		if( $hash !== $this->config->item('salt') ){
			die('Not welcome');
		}		
		
		$this->load->helper('cron');
	}
	
	/**
	 * Displays an log error
	 * @author Baidoc
	 */
	function log_reader(){
		$log_date = $this->input->get('log_date');
		
		if( ! is_numeric($log_name) ){
			return;
		}
		
		$file = 'log-' . date('Y-m-d',$log_date) . '.php';
		
		if( file_exists(APPPATH . 'logs/' . $file) ){
			$contents = file_get_contents(APPPATH . 'logs/' . $file);
			die($contents);		
		}
	}
	
	/**
	 * Sends errors to gateway
	 * @return 
	 */
	function error_reporter(){
		//daily error log
		if(file_exists(APPPATH.'logs/log-' . date('Y-m-d',strtotime('yesterday')). '.php')){
			
			$file_name 	= APPPATH.'logs/log-' . date('Y-m-d',strtotime('yesterday')). '.php';
			$nr_lines 	= count(file($file_name)); 
			  			
			$post_fields = 'website='.$this->config->item('base_url') . '&key=' . WEBSITE_LICENSE. '&file_name=' . urlencode($file_name) . '&errors_nr=' . $nr_lines;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://www.modenacam.com/error_reporter');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch);
			curl_close($ch);			
		}
	}
	
	/**
	 * Inchide performerii ramasi agatati online
	 * @author Baidoc
	 */
	function shutdown_frozen_chatrooms(){
		$this->load->model('performers_ping');
		
		$performers = $this->performers_ping->get_multiple_expired_pings(strtotime('-5 minutes'));
		
		if(sizeof($performers) == 0){
			return FALSE;
		}
		
		$this->load->model('performers');
		foreach( $performers as $performer ){
			$this->db->trans_begin();
						
			$this->performers->update($performer->performer_id, array('is_online'=>0,'is_online_type'=>NULL,'is_in_private'=>0));
			$this->performers_ping->delete($performer->performer_id);
			
			if( $this->db->trans_status() === FALSE ){ 
				$this->db->trans_rollback();
				continue;
			}
			
			$this->db->trans_commit();			
		}
	}
	
	/**
	 * Inchide sessiunile din watchers ce au ramas in aer.. 
	 */
	function closed_frozen_watchers(){
		$this->load->model('watchers');
		$frozen = $this->watchers->get_multiple_frozen_sessions(time() - 60*2);
		
		if(sizeof($frozen) == 0){
			return;
		}
		
		$this->load->model('users');
		$this->load->model('performers');
		$this->load->model('studios');
		
		foreach($frozen as $session){
			
			$performer = $this->performers->get_one_by_id($session->performer_id);
			
			if( ! $performer ){
				continue;
			}
			
			//incep sa sug/adaug credite
			$this->db->trans_begin();
			
			$update['show_is_over'] = 1;
			if( $session->end_date == 0 ){
				$update['end_date'] = time();
			}			
			
			//inchid sessiunea
			$this->watchers->update($session->id,$update);
			
			if( $session->user_paid_chips > 0) {
				//sterg chipsuri de la user
				$this->users->add_credits($session->user_id,-$session->user_paid_chips);
				
				//adaug chipsuri la performer
				$this->performers->add_credits($session->performer_id,$session->performer_chips);
				
				//adaug chipsuri la studio
				if($session->studio_id){
					$this->studios->add_credits($session->studio_id,$session->studio_chips);
				}
			}
						
			//fac rollback
			if( $this->db->trans_status() == FALSE ){
				$this->db->trans_rollback();
				continue;
			}
			
			$this->db->trans_commit();	
		}
	}
	
	/*
	 * Genereaza platile
	 */
	function generate_payments(){
		//iau toate studiourile
		$this->load->model('studios');
		$this->load->model('performers');
		$this->load->model('payments');
		$this->load->helper('credits');
		$this->is_purified = TRUE;
		
		$this->load->model('payment_methods');
		$methods = prepare_objects($this->payment_methods->get_all_approved());
		
		$this->load->model('affiliates');
		$this->load->model('ad_traffic');
		
		$affiliates = $this->affiliates->get_all_approved();
		
		//data limita pana la care se face plata (ultima zi din luna,  sau mijlocu 15
		$up_to_date_payment = get_last_day_of_interval(time());
		
		if(sizeof($affiliates) > 0){
			foreach($affiliates as $affiliate){
				
				if( convert_chips_to_value($affiliate->credits) < $affiliate->release ){
					continue;
				} 
				
				$last_payment = $this->payments->get_last_payment_by_filters( array('affiliate_id'=>$affiliate->id) );
				
				//payment prea des.. se face din 15 in 15 zile
				if( $last_payment){
					//daca au fost facute 2 plati in intervalul actual sau
					if(date('j',$last_payment->paid_date) <=16 && date('j') < 16 && date('n',$last_payment->paid_date) == date('n') && floor(abs(time() - $last_payment->paid_date)/(60*60*24)) < 11 ){
						continue;
					}
				
					//daca au fost facute 2 plati in intervalul actual sau
					if(date('j',$last_payment->paid_date) >= 16 && date('j') > 16 && date('n',$last_payment->paid_date) == date('n') && floor(abs(time() - $last_payment->paid_date)/(60*60*24)) < 11 ){
						continue;
					}
				
					$last_payment_day = $last_payment->to_date+1;
				} else {
					$last_payment_day = get_first_day_of_interval($affiliate->register_date);
				}
				
				$affiliate_chips = $this->ad_traffic->get_earnings_by_affiliate_id($affiliate->id, $last_payment_day, $up_to_date_payment);

				//are 0 credite
				if( ! $affiliate_chips ){
					continue;
				}
					
				//nu are destule chipsuri
				if( convert_chips_to_value($affiliate_chips) < $affiliate->release ){
					continue;
				}
					
				//incep tranzactia
				$this->db->trans_begin();
					
				$payment_status = 'invalid';
				$payment_name 	= '';
				if( isset($methods[$affiliate->payment]) ){
					$payment_status = 'pending';
					$payment_name	= $methods[$affiliate->payment]->name;
				}
					
				//generez o plata pt performeru curent
				$this->affiliates->add_credits($affiliate->id, -$affiliate_chips);
				
				$this->payments->add(time(),$last_payment_day,$up_to_date_payment,$affiliate_chips,$payment_status,'',$affiliate->account,$payment_name,NULL,NULL,$affiliate->id);
					
				$this->system_log->add(
					NULL,
					NULL,
					'affiliate',
					$affiliate->id,
					'generate_payment',
					sprintf('Removed %s from affiliate account for %s',print_amount_by_currency($affiliate_chips,FALSE,TRUE,FALSE),print_amount_by_currency($affiliate_chips)),
					time(),
					ip2long($this->input->ip_address())
				);
					
				if( $this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
				}
					
				$this->db->trans_commit();				
				
			}
		}
		
		$studios = $this->studios->get_all();
				
		//data limita pana la care se face plata (ultima zi din luna,  sau mijlocu 15
		$up_to_date_payment = get_last_day_of_interval(time());
		
		//last_payment_day e  ziua din care incepe sa se faca plata
		
		$this->load->helper('cron');
			
		
		if(sizeof($studios) > 0){
			
			//pentru fiecare studio verific daca release amountul e indeplinit 
			foreach($studios as $studio){
				//e ok poate fi platit
				if( convert_chips_to_value($studio->credits) >= $studio->release ){
					//verific daca a trecut cel putin 15 zile de la ultima plata
					$last_payment = $this->payments->get_last_payment_by_filters(array('studio_id'=>$studio->id));
						
					//payment prea des.. se face din 15 in 15 zile
					if( $last_payment){
						//daca au fost facute 2 plati in intervalul actual sau  
						if(date('j',$last_payment->paid_date) <=16 && date('j') < 16 && date('n',$last_payment->paid_date) == date('n') && floor(abs(time() - $last_payment->paid_date)/(60*60*24)) < 11 ){
							continue;
						}
						
						//daca au fost facute 2 plati in intervalul actual sau  
						if(date('j',$last_payment->paid_date) >= 16 && date('j') > 16 && date('n',$last_payment->paid_date) == date('n') && floor(abs(time() - $last_payment->paid_date)/(60*60*24)) < 11 ){
							continue;
						}

						$last_payment_day = $last_payment->to_date+1;
					} else {
						$this->load->model('watchers');
						$watcher = $this->watchers->get_first_activity_by_studio_id($studio->id);
						if( ! $watcher ){		
							continue;
						}
						$last_payment_day = get_first_day_of_interval($watcher->start_date);
					}
	
					//cate credite a castigat in perioada respectiva
					$studio_chips = $this->watchers->get_total_credits_by_studio_id($studio->id,$last_payment_day,$up_to_date_payment);
					//nu a castigat credite in per respetiva
					if( ! $studio_chips ){
						continue;
					}
						
					if( convert_chips_to_value($studio_chips) < $studio->release ){
						continue;
					}
					
					//incep tranzactia
					$this->db->trans_begin();

					//generez plata pt studio
					$this->studios->add_credits($studio->id, -$studio_chips);

					$payment_status = 'invalid';
					$payment_name 	= '';
					if( isset($methods[$studio->payment]) ){
						$payment_status = 'pending';
						$payment_name	= $methods[$studio->payment]->name;
					}
					
					$this->payments->add(time(),$last_payment_day,$up_to_date_payment,$studio_chips,$payment_status,'',$studio->account,$payment_name,$studio->id);					
					
					$this->system_log->add(
						NULL,
					    NULL,
						'studio',
						$studio->id,
						'generate_payment',
						sprintf('Removed %s from studio account for %s',print_amount_by_currency($studio_chips,FALSE,TRUE,FALSE),print_amount_by_currency($studio_chips)),
						time(),
						ip2long($this->input->ip_address())
					);
										
					$performers = $this->performers->get_multiple_performers(array('studio_id'=>$studio->id));
					
					//pentru fiecare performer generez plata
					foreach( $performers as $performer ){
						if( $performer->credits > 0 ){
								
							$performer_chips = $this->watchers->get_total_credits_by_performer_id($performer->id,$last_payment_day,$up_to_date_payment);
								
							if( $performer_chips == 0 ){
								continue;
							}
							
							//generez o plata pt performeru curent
							$this->performers->add_credits($performer->id, -$performer_chips);
							$this->system_log->add(
								NULL,
								NULL,
								'performer',
								$performer->id,
								'generate_payment',
								sprintf('Removed %s from performer account for %s',print_amount_by_currency($performer_chips,FALSE,TRUE,FALSE),print_amount_by_currency($performer_chips)),
								time(),
								ip2long($this->input->ip_address())
							);
														
							$this->payments->add(time(),$last_payment_day,$up_to_date_payment,$performer_chips,$payment_status,'',$performer->account,$payment_name,$studio->id,$performer->id);														
						}
					}
					
					if( $this->db->trans_status() == FALSE ){
						$this->db->trans_rollback();
					}
						
					$this->db->trans_commit();
				}
			}
		}
		
		
		//generare plati pentru performeri fara studio
		$performers = $this->performers->get_multiple_performers_for_payments_cron();
		
		if(sizeof($performers) > 0){
			foreach($performers as $performer){
				
				if( convert_chips_to_value($performer->credits) >= $performer->release ){

					//verific daca a trecut cel putin 15 zile de la ultima plata
					$last_payment = $this->payments->get_last_payment_by_filters(array('performer_id'=>$performer->id));
					
					//payment prea des.. se face din 15 in 15 zile
					if( $last_payment){
						
						//daca au fost facute 2 plati in intervalul actual sau  
						if(date('j',$last_payment->paid_date) < 16 && date('j') < 16 && date('n',$last_payment->paid_date) == date('n') && floor(abs(time() - $last_payment->paid_date)/(60*60*24)) < 11 ){
							continue;
						}
						
						//daca au fost facute 2 plati in intervalul actual sau  
						if(date('j',$last_payment->paid_date) > 16 && date('j') > 16 && date('n',$last_payment->paid_date) == date('n') && floor(abs(time() - $last_payment->paid_date)/(60*60*24)) < 11 ){
							continue;
						}
						
						$last_payment_day = $last_payment->to_date+1;
												
					} else {
						
						$this->load->model('watchers');
						$watcher = $this->watchers->get_first_activity_by_performer_id($performer->id);
						if( ! $watcher ){
							continue;
						}						
						$last_payment_day = get_first_day_of_interval($watcher->start_date);			
									
					}
							
					$performer_chips = $this->watchers->get_total_credits_by_performer_id($performer->id, $last_payment_day,$up_to_date_payment);	
					
					//are 0 credite
					if( ! $performer_chips ){
						continue;
					}
					
					//nu are destule chipsuri
					if( convert_chips_to_value($performer_chips) < $performer->release ){
						continue;
					}
					
					//incep tranzactia
					$this->db->trans_begin();
					
					$payment_status = 'invalid';
					$payment_name 	= '';
					if( isset($methods[$performer->payment]) ){
						$payment_status = 'pending';
						$payment_name	= $methods[$performer->payment]->name;
					}					
					
					//generez o plata pt performeru curent
					$this->performers->add_credits($performer->id, -$performer_chips);
					$this->payments->add(time(),$last_payment_day,$up_to_date_payment,$performer_chips,$payment_status,'',$performer->account,$payment_name,NULL,$performer->id);
					
					$this->system_log->add(
						NULL,
						NULL,
						'performer',
						$performer->id,
						'generate_payment',
						sprintf('Removed %s from performer account for %s',print_amount_by_currency($performer_chips,FALSE,TRUE,FALSE),print_amount_by_currency($performer_chips)),
						time(),
						ip2long($this->input->ip_address())
					);					
					
					if( $this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
					}
					
					$this->db->trans_commit();					
					
				}
			}
		} 
	}
	
	/*
	 * Muta watcherii closed in tabela lor
	 * @tutorial: recomandare 10 min 
	 */
	function move_watchers(){
		$this->load->model('watchers');
		$watchers = $this->watchers->move_old_watchers(); 
	}
	
	/**
	 * Updateaza balanta pt fmsuri
	 */
	function update_fms_ballance(){
		$this->load->model('performers');
		
		$on_fms = $this->performers->get_multiple_count_grouped_by_fms();
		
		if(sizeof($on_fms) == 0){
			return;
		}
		
		$this->load->model('fms');
		foreach($on_fms as $fms){
			$this->fms->update($fms->fms_id,array('current_hosted_performers'=>$fms->number));
		}
	}
	
	/**
	 * Updateaza in tabela categories cati performeri is online din fiecare categorie
	 * @return unknown_type
	 */
	function update_online_performers(){
		
		$this->load->model('categories');
		$this->load->model('performers');
		
		$categories = $this->categories->get_all_categories();
		
		if(sizeof($categories) == 0) return;
		
		foreach($categories as $category){
			$online_performers = $this->categories->count_online_performers_by_category_id($category->id);
			$this->categories->update($category->id,
										array(
											'performers_online'	=> ($online_performers->online_performers)?$online_performers->online_performers:0,
											'performers_total'	=> $online_performers->performers_total
										)
									);
		}
	}
	
	/**
	 * Sterge fisierele mai vechi de o zi
	 * @return unknown_type
	 */
	function delete_old_files(){
		$files = array();
		$index = array();
		$yesterday = strtotime('-25 hours');
		
		if ($handle = opendir(MY_TEMP_PATH)) {
			clearstatcache();
			while (false !== ($file = readdir($handle))) {
		   		if ($file != "." && $file != "..") {
		   			$files[] = $file;
					$index[] = filemtime(MY_TEMP_PATH.'/'.$file );
		   		}
			}
		  	closedir($handle);
		}
		
		asort( $index );
		
		foreach($index as $i => $t) {
		
			if($t < $yesterday) {
				@unlink(MY_TEMP_PATH.'/'.$files[$i]);
			}
		
		}		
	}
	
	/**
	 * Sterge userii neconfirmati in 24 hours
	 * @return unknown_type
	 */
	function delete_old_users(){
		$this->load->model('users');
		$loop = TRUE;
		$offset = 0;
		while($loop){
			$users = $this->users->get_multiple(array('register_date'=>strtotime('-24 hours'),'status'=>'pending'),100,$offset);
			
			if( sizeof($users) == 0 ) { 
				$loop = FALSE;
				continue;
			}
			
			foreach($users as $user){
				$this->db->where('id',$user->id)->delete('users');
			}
			
			$offset += 100;
			
		}
	}
	
	/**
	 * Newsletter cron
	 *
	 * wget -q http://example.com/crons/newsletters/
	 *
	 * @runevery	1 minute
	 *
	 * @author		CagunA
	 * @since		16 september, 2011
	 */
	function newsletters() {
		
		$this->load->model('newsletter_cron');
		
		// Get one newsleter cron
		$newsletterCrons = $this->newsletter_cron->get_all(10);
		
		// If exists
		if(is_array($newsletterCrons) AND count($newsletterCrons) > 0) {
			foreach ($newsletterCrons as $newsletterCron) {
				
				############################################################################
				###   MAIL   ###############################################################

				
					$this->load->library('email');
					$this->email->from(SUPPORT_EMAIL, SUPPORT_NAME);
					$this->email->to($newsletterCron->recipient_email);
					$this->email->subject($newsletterCron->email_subject);
					$this->email->message($newsletterCron->email_body);
					$mailSend = $this->email->send();

				
				############################################################################
				############################################################################

				// If email send, delete the DB recod by id
				if($mailSend) {					
					$this->newsletter_cron->update($newsletterCron->id,array('sent'=>1));
				} else {
					$this->newsletter_cron->update($newsletterCron->id,array('sent'=>2));					
				}
				
			}
		}
	}
	
	/**
	 * Sincronizarea limbii
	 * @author Baidoc
	 */
	function lang_sync(){
		$this->load->helper('lang_support');
		
		//detectez limbile vorbite
		$languages = language_init();

				
		//generez arrayul de translationuri
		$this->load->helper('directory');
		$directories 	= directory_map('application/');
		$translations 	= get_lang_array($directories);

		populate_langs($languages, $translations);
	}
	
}