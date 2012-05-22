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
 * @property Categories $categories
 * @property Ad_zones $ad_zones
 */
Class Promo_controller extends MY_Affiliate {
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('affiliates');
		$this->load->model('ad_zones');
		$this->load->model('categories');
		$this->load->library('form_validation');
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * PErformer deafult page
	 * @return unknown_type
	 */
	function index(){		
		
		$this->load->helper('credits');
		
		$data['ad_zones']				= $this->ad_zones->get_by_affiliate_id($this->user->id);
		

		$data['page']					= 'ad_zones';
		$data['description']			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords']				= SETTINGS_SITE_KEYWORDS;
		$data['page_title']				= lang('Your ad zones').' - '.SETTINGS_SITE_TITLE;

		$this->load->view('template', $data);
		return;
	}
	
	// ------------------------------------------------------------------------------------------	
	/**
	 * Creaza o zona de aduri
	 * @author Baidoc
	 */
	function create_ad_zone(){
		
		$this->form_validation->set_rules('name', lang('Name'), 'trim|required|purify');
		
		if($this->form_validation->run() == FALSE){
			
			
			$data['ad_hash']				= uniqid(time(), TRUE);
			$data['link_location']			= get_promo_link_otions();
			$data['categories']				= $this->categories->get_all_categories();
			$data['promo_types']			= get_promo_ads_types();
			$data['page']					= 'create_ad_zone';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']				= lang('Create Ad Zone').' - '.SETTINGS_SITE_TITLE;
			

			$this->load->view('template', $data);
			return;
		}
		
		$ad['add_date']				= time();
		$ad['affiliate_id']			= $this->user->id;
		$ad['name']					= $this->input->post('name');
		$ad['hash']					= $this->input->post('ad_hash');
		$ad['type']					= $this->input->post('ad_type');
		$ad['category_link']		= $this->input->post('category');
		$ad['performers_status']	= $this->input->post('performers_status');
		$ad['border_color']			= $this->input->post('border_color');
		$ad['bg_color']				= $this->input->post('bg_color');
		$ad['text_color']			= $this->input->post('text_color');
		$ad['link_location']		= $this->input->post('link_location');
		
		if(!$this->ad_zones->save($ad)){
			$this->em->set('error', lang('Ad zone was not created. Please try again!'));
			redirect(current_url());
		}
		
		$this->em->set('error', lang('Ad zone was not created. Please try again!'));
		redirect(site_url('promo/get_code/'.$ad['hash']));
		
	}
	
	// -------------------------------------------------------------------------------------
	/**
	 * Editeaza o zona de aduri
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function edit_ad_zone($id = FALSE){
		if($id <= 0){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message'=>lang('This ad zone dosen`t exist!')));
			redirect('promo');
		}
		
		$ad_zone = $this->ad_zones->get_by_id($id);
		
		if(!is_object($ad_zone)){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message'=>lang('This ad zone dosen`t exist!')));
			redirect('promo');
		}
		
		$this->form_validation->set_rules('name', lang('Name'), 'trim|required|purify');
		
		if($this->form_validation->run() == FALSE){
		
			$data['ad_zone']				= $ad_zone;
			$data['link_location']			= get_promo_link_otions();
			$data['categories']				= $this->categories->get_all_categories();
			$data['promo_types']			= get_promo_ads_types();
			$data['page']					= 'create_ad_zone';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']				= lang('Edit ').$ad_zone->name.lang(' Ad Zone').' - '.SETTINGS_SITE_TITLE;

			$this->load->view('template', $data);
			return;
		}
		
		$ad['id']					= $ad_zone->id;
		$ad['name']					= $this->input->post('name');
		$ad['hash']					= $this->input->post('ad_hash');
		$ad['type']					= $this->input->post('ad_type');
		$ad['category_link']		= $this->input->post('category');
		$ad['performers_status']	= $this->input->post('performers_status');
		$ad['border_color']			= $this->input->post('border_color');
		$ad['bg_color']				= $this->input->post('bg_color');
		$ad['text_color']			= $this->input->post('text_color');
		$ad['link_location']		= $this->input->post('link_location');
		
		if(!$this->ad_zones->save($ad)){
			$this->em->set('error', lang('Ad zone was not updated. Please try again!'));
			redirect(current_url());
		}
		
		$this->em->set('success', lang('Ad zone was updated!'));
		redirect(site_url('promo/get_code/'.$ad['hash']));
		
		
	}

	
	// -------------------------------------------------------------------------------------
	/**
	 * Afiseaza reclama dupa hash
	 * @param unknown_type $hash
	 * @author Baidoc
	 */
	function get_code($hash = FALSE){
		if( ! $hash ){
			$this->em->set('error', lang('This ad zone not exist!'));
			redirect(site_url('promo'));				
		}
				
		$ad = $this->ad_zones->get_one_by_hash($hash);
		
		if(!is_object($ad)){
			$this->em->set('error', lang('This ad zone not exist!'));
			redirect(site_url('promo'));
		}
		
		$text_color				= str_replace('#', '', $ad->text_color);
		list($width, $height) 	= explode('x', $ad->type, 2); 
		list($height, $nr_of_performers) = explode('/', $height, 2);
		
		$data['code'] = '<iframe src="'.main_url().'ads/promo/'.$this->user->token.'/'.$ad->category_link.'/'.$width.'/'.$height.'/'.$nr_of_performers.'/'.$text_color.'/'.$ad->performers_status.'/'.$ad->hash.'" width="'.$width.'" height="'.$height.'" style="border:solid 1px '.$ad->border_color.'; overflow:hidden; background:'.$ad->bg_color.'"></iframe>';
		
		$data['page']					= 'get_ad_zone';
		$data['description']			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords']				= SETTINGS_SITE_KEYWORDS;
		$data['page_title']				= lang('Get ad code').' - '.SETTINGS_SITE_TITLE;

		$this->load->view('template', $data);
	}
	
	
	// -------------------------------------------------------------------------------------
	/**
	 * Sterge o zona de aduri
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function delete($id){
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message'=>lang('This ad zone dosen`t exist!')));
			redirect('promo');
		}
		
		$ad_zone = $this->ad_zones->get_by_id($id);
		
		if(!is_object($ad_zone)){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message'=>lang('This ad zone dosen`t exist!')));
			redirect('promo');
		}
		
		$this->ad_zones->delete($id);
		
		$this->session->set_flashdata('msg', array('success' => true, 'message'=>lang('This ad zone was deleted!')));
		redirect('promo');
	}	
}