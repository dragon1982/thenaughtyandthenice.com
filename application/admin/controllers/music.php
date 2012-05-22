<?php
class Music_controller extends MY_Admin{
	
	/*
	 * Construct
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('music');
	}
	
	/**
	 * Listare muzica
	 * @author Baidoc
	 */
	function index(){	
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('music/index/page/');
		$config['uri_segment'] 	= 4;
		$config['total_rows']   = $this->music->get_all(FALSE,FALSE,TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();
				
		$data['songs']			= $this->music->get_all($config['per_page'],$this->uri->segment(4));
				
		$data['page'] = 'music/index';
		
		$data['breadcrumb'][lang('Music')]	= 'current';
		$data['page_head_title']				= lang('Music manager');
		
		$this->load->view('template', $data);		
	}
	
	/*
	 * Adauga melodie
	 */
	function add(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title',lang('title'),'trim|required');
		$this->form_validation->set_rules('music',lang('music'),'required|has_uploaded_music');
		
		if( $this->form_validation->run() === FALSE ){ 
			$data['page'] = 'music/add';
			
			$data['breadcrumb'][lang('Music')]	= 'current';
			$data['page_head_title']			= lang('Music manager - Add');
			
			$this->load->view('template', $data);
		} else {
			$this->music->add($this->input->post('title'),$this->image_data['file_name']);
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Song added!')));
			redirect('music');			
		}
	}
	
	/**
	 * Editeaza o melodie
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function edit($id = FALSE){
		if( ! $id ){
			redirect('music');
		}
		
		$melodie = $this->music->get_one_by_id($id);
		
		if( ! $melodie ){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('Invalid id!')));
			redirect('music');			
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title',lang('title'),'trim|required');

		if( $this->form_validation->run() === FALSE ){
			$data['page'] = 'music/edit';
				
			$data['breadcrumb'][lang('Music')]	= 'current';
			$data['page_head_title']			= lang('Music manager - Edit');
			$data['song']						= $melodie;
			
			$this->load->view('template', $data);		
		} else {
			$this->music->update($melodie->id,array('title'=>$this->input->post('title')));

			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Song edited!')));
			redirect('music');			
		}
	}
	
	/**
	 * Sterge o melodie
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function delete($id = FALSE){
		if( ! $id ){
			redirect('music');
		}
		
		$melodie = $this->music->get_one_by_id($id);
		
		if( ! $melodie ){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('Invalid id!')));
			redirect('music');
		}
		
		@unlink('uploads\stuff\\' . $melodie->src);
		
		$this->music->delete_one_by_id($id);
		
		$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Song deleted!')));
		redirect('music');		
	}
}