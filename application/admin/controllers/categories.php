<?php
class Categories_controller extends MY_Admin {
	
	/**
	 * Cosnstructor
	 * @author Baidoc
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('categories');
		$this->load->library('form_validation');
		$this->load->helper('filters');
		$this->load->helper('utils');		
	}
	
	/**
	 * Listare categorii
	 * @author Baidoc
	 */
	function index() {
		$filters	= purify_filters($this->input->get('filters'),'categories');
		$order		= purify_orders($this->input->get('orderby'),'categories');
		
		$data['filters']	= array2url($filters,'filters');
		$data['order_by']	= $this->input->get('orderby');
				
		$categories		= $this->categories->get_all($filters, FALSE, implode_order($order));
		
		if( sizeof($categories) > 0){
			foreach($categories as $category){
				$data['categories'][$category->id] = $category;
			}
		}
				
		$data['page'] = 'categories';
		$data['breadcrumb'][lang('Categories')]	= 'current';
		$data['page_head_title']				= lang('Categories'); 
		
		$this->load->view('template', $data);
		
	}
	
	
	function add_or_edit($id = 0){
		
		if($id > 0){
			$category = $this->categories->get_by_id($id);
			$data['category'] = $category;
			
			$this->form_validation->set_rules('name', lang('name'), 'required|trim|min_length[3]|max_length[25]|alpha_dash|update_unique[categories.name.'.$category->id.']|strip_tags|purify');
		}else{
			$this->form_validation->set_rules('name', lang('name'), 'required|trim|min_length[3]|max_length[25]|alpha_dash|Unique[categories.name]|strip_tags|purify');
		}
		
		
		if($this->form_validation->run() == FALSE){
			
			$data['categories']['parent_id'] = lang('No parent');
			$categories = $this->categories->get_all();
			if(is_array($categories)){
				foreach($categories as $_category){
					if($id != $_category->id){
						$data['categories'][$_category->id] = $_category->name;
					}
				}
			}
			
			
			$data['breadcrumb'][lang('Categories')] = base_url().'categories';
			
			if($id > 0){
				$data['page_head_title'] = lang('Edit category');
				$data['breadcrumb'][lang('Edit category')] = 'current';
			}else{
				$data['page_head_title'] = lang('Add category');
				$data['breadcrumb'][lang('Add category')] = 'current';
			}
			
			$data['page'] = 'categories_add_or_edit';
			$this->load->view('template', $data);
			return;
		}
		
		if($id > 0){
			$rows['id']			= $category->id;
		}
				
		$rows['name'] = $this->input->post('name');
		$rows['link'] = url_title($this->input->post('name'));
		$rows['parent_id'] = ($this->input->post('parent_id') > 0) ? $this->input->post('parent_id') : null;
		
		if($this->categories->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Category was saved successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'other', 
            			NULL, 
            			($id > 0) ? 'edit_category' : 'add_category', 
            			($id > 0) ? 'Admin edited a category' : 'Admin added a new category', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Category was not saved! Please try again!')));
		}
		$this->write_to_filters();
		redirect('categories');
		
	}
	
	
	function delete($id =  FALSE){
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
		$this->load->model('performers_categories');
		
		$performers_in_cat = $this->performers_categories->get_all(array('category_id'=>$id), TRUE);
		
		if($performers_in_cat > 0){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => sprintf(lang('You cannt delete this category because it is asigned to %s performers!'), $performers_in_cat)));
			redirect($referer);
		}
		
		if($this->categories->get_all(array('id' => $id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This category does not exist!')));
			redirect($referer);
		}
		
		$childrens = $this->categories->get_childres($id);
		if(sizeof($childrens) > 0){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('Delete the subcategories underneath this category first!')));
			redirect($referer);			
		}
		
		if($this->categories->delete($id)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Category was successfully deleted!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'other', 
            			NULL, 
            			'delete_category', 
            			'Admin deleted a category', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Category cannot be deleted! Please try again!')));
		}
		$this->write_to_filters();
		redirect($referer);
	}
	
	# scrie array-ul modificat de categorii in config-ul de la main
	function write_to_filters() {
		
		$config_categories = '<?php';
		$config_categories .= PHP_EOL;
		$config_categories .= '$config[\'filters\'][\'category\'] = array(lang(\'category\') => array (' . PHP_EOL;
		$categories = $this->categories->get_all();
		
		foreach($categories as $category) {
			$config_categories .= 'lang(\'' . $category->name . '\') => \'' . $category->link . '\',' . PHP_EOL;
		}
		
		# scot ultima virgula pentru a tipari un array valid
		$config_categories = substr($config_categories, 0, -2
		);
		$config_categories .= PHP_EOL . ')' . PHP_EOL;
		$config_categories .= ');' . PHP_EOL;
		# scriu array-ul in categories.php
		write_file('./application/main/config/categories.php', $config_categories, 'w');
	}
	
}