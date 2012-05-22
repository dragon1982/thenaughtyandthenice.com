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
 * @property performers $performers
 * @property contracts $contracts
 */
class Contracts_controller extends MY_Studio_Edit{
	
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('contracts');
	}
	
	/*
	 * Listeaza contractele studioului
	 */
	function index(){
		$data['contracts']				= $this->contracts->get_multiple_by_performer_id($this->performer->id);
        $data['description'] 	       = SETTINGS_SITE_DESCRIPTION;
        $data['keywords'] 		       = SETTINGS_SITE_KEYWORDS;
        $data['pageTitle'] 		       = $this->performer->nickname.'\'s '.lang('contracts').' - '.SETTINGS_SITE_TITLE;
		$data['_performer_menu']		= TRUE;        
        $data['_sidebar']		       = TRUE;
        $data['page']			       = 'performers/contracts/index';		
    
        $this->load->view('template', $data);			
	}
	
	/**
	 * Adauga un contract
	 */
	function add(){		
		$approved_contracts = $this->contracts->get_multiple_by_performer_id($this->performer->id,array('status'=>'approved'),TRUE);			
		if( $approved_contracts ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Performer already have an approved contract')));
			redirect('performer/contracts');
		}
		
		$total_contracts = $this->contracts->get_multiple_by_performer_id($this->performer->id,FALSE,TRUE);
		if( $total_contracts > 9 ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Performer exceeded the maximum allowed contract number')));
			redirect('performer/contracts');
		}		
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('contract',		lang('contract'),	'trim|required|performer_contract');
		
		if( $this->form_validation->run() === FALSE ){				
			$data['contract']				= ($this->session->userdata('contract'))?$this->session->userdata('contract'):FALSE;
						
	        $data['description'] 	       = SETTINGS_SITE_DESCRIPTION;
	        $data['keywords'] 		       = SETTINGS_SITE_KEYWORDS;
	        $data['pageTitle'] 		       = $this->performer->username.'\'s '.lang('add contract').' - '.SETTINGS_SITE_TITLE;
			$data['_performer_menu']		= TRUE;
        	$data['_sidebar']		       = TRUE;
			 $data['page']			       = 'performers/contracts/add';		
	    
	        $this->load->view('template', $data);			
		} else {
			
			$this->load->helper('directories');
			$this->load->model('contracts');							
			foreach( $this->good_contracts as $contract ){	
				$name = generate_unique_name('uploads/performers/' . $this->performer->id . '/others/',$contract['name']);
				
				//move the contract to his place
				@rename(MY_TEMP_PATH.'/' . $contract['file_on_disk_name'],'uploads/performers/' . $this->performer->id . '/others/' . $name);
				$this->contracts->add($name,'pending',NULL,$this->performer->id);
			}
			
			$this->load->model('performers');
			$this->performers->update($this->performer->id, array('contract_status'=>'pending'));			
			$this->session->unset_userdata('contract');
			
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Contract added')));
			redirect('performer/contracts');			
		}		
	}
	
	/*
	 * Sterge un contract
	 */
	function delete( $contract_id = FALSE ){
		if( ! $contract_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid contract')));
			redirect('performer/contracts');
		}
		
		$contract = $this->contracts->get_one_by_id($contract_id);
		if( ! $contract ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid contract')));
			redirect('performer/contracts');			
		}
		
		if( $contract->performer_id !== $this->performer->id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Cannot delete a contrat that is not yours')));
			redirect('performer/contracts');						
		}
		
		if( $contract->status == 'approved' ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Cannot delete an approved contrat')));
			redirect('performer/contracts');									
		}
		
		if( ! $this->contracts->delete_by_id($contract_id) ){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Could not delete the contract')));
			redirect('performer/contracts');												
		}
		
		@unlink('uploads/performers/' . $this->performer->id . '/others/' . $contract->name_on_disk);		
		$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Contract removed.')));
		redirect('performer/contracts');														
	}
}