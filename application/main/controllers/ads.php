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
 * @property Performers $performers
 * @property Watchers $watchers
 * @property Credits $credits
 * @property Affiliates $affiliates
 */
Class Ads_controller extends MY_Controller {
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('ad_zones');
		$this->load->model('ad_traffic');
		$this->load->model('affiliates');
		$this->load->library('form_validation');
		
		$this->output->enable_profiler(FALSE);
	}
	
	
	//aici ajunge cand da fraierul click pe reclame.
	function index($performer_nick, $link_location, $hash){
		$ad_zone = $this->ad_zones->get_one_by_hash($hash);
		
		if(is_object($ad_zone)){
			$ad['id'] = $ad_zone->id;
			
			$ad['hits'] = $ad_zone->hits + 1;
			$this->ad_zones->save($ad);
			
			
			$traffic['ad_id'] = $ad_zone->id;
			$traffic['affiliate_id'] = $ad_zone->affiliate_id;
			$traffic['date'] = time();
			$traffic['action'] = 'hit';
			$this->ad_traffic->save($traffic);
			
			$this->load->helper('cookie');
			
			set_cookie('affiliate_id', $ad_zone->affiliate_id, 60*60*24*7);
			set_cookie('affiliate_ad_id', $ad_zone->id, 60*60*24*7);
		}else{
			$affiliate = $this->affiliates->get_one_by_hash($hash);
			
			if(is_object($affiliate)){
				$traffic['ad_id'] = null;
				$traffic['affiliate_id'] = $affiliate->id;
				$traffic['date'] = time();
				$traffic['action'] = 'hit';
				$this->ad_traffic->save($traffic);
				
				set_cookie('affiliate_id', $affiliate->id, 60*60*24*7);
			}
		}
		
		//to free chat
		if($link_location == 2){
			redirect('room/'.$performer_nick);
			
		}elseif($performer_nick != '0'){
			redirect($performer_nick);
		}
		
		redirect();
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * PErformer deafult page
	 * @return unknown_type
	 */
	function promo($token = FALSE, $cat = FALSE, $width = FALSE, $height = FALSE,$nr_of_performers = '1',  $text_color = 'ffffff',$performer_online = 'false',  $hash = FALSE, $in_main_site = FALSE){
		$this->load->model('performers');
		$this->load->model('ad_zones');
		
		$ad_zone = $this->ad_zones->get_one_by_hash($hash);
		
		
		
		$data['link_location'] = 0;
		
		// daca reclama nu e afisata pe site, pe pagina create sau edit ad_zone
		if(!$in_main_site){
			
			if(is_object($ad_zone)){
				$ad['id'] = $ad_zone->id;
				$ad['views'] = $ad_zone->views + 1;
				$this->ad_zones->save($ad);
				
				
				$traffic['ad_id'] = $ad_zone->id;
				$traffic['affiliate_id'] = $ad_zone->affiliate_id;
				$traffic['date'] = time();
				$traffic['action'] = 'view';
				$this->ad_traffic->save($traffic);
				

				$data['link_location'] = $ad_zone->link_location;
			}else{
				die;
			}
		}
		
		
		$this->load->helper('filters');
		
		$filters = array();
		
		if($cat){
			$filters['category'][] = $cat;
		}
		
		if($performer_online == 'true'){
			 $filters['is_online'][] = TRUE;
		}
		
		if($nr_of_performers > 0){
			$limit = $nr_of_performers;
		}else{
			$limit = '4';
		}
		
		//TODO: De vazut cum facem cu purify filters sa le vada si pe astea
		$this->is_purified = TRUE;
		//$filters = purify_filters($filters);
		
		
		$data['performers']		= $this->performers->get_multiple_performers($filters, $limit);
		$data['width']			= $width;
		$data['height']			= $height;
		$data['text_color']		= '#'.$text_color;
		$data['token']			= $token;
		$data['hash']			= $hash;
		
		$this->load->view('affiliate_promo_ads', $data);
	}


	
}