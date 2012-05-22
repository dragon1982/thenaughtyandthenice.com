<?php 
/**
 * Reguli de validare.
 * @author Andrei
 *
 */
class MY_Form_validation extends CI_Form_validation{
		
	// --------------------------------------------------------------------
	
	/**
	 * Verifica daca in tabelul primit exista deja valoarea $value
	 * @param $value -> valoarea ce trebuie cautata
	 * @param $params -> string concatenat din Tabela.camp
	 * @return bool
	 */
	function Unique($value, $params) {

		$CI =& get_instance();
		$CI->load->database();

		$CI->form_validation->set_message('Unique',
			lang('The %s already exists!'));


		list($table, $field) = explode(".", $params, 2);
		

		$query = $CI->db->select($field)->from(strtolower($table))
			->where($field, $value)->limit(1)->get();

		if ($query->row()) {			
			return FALSE;
		} else {
			return TRUE;
		}
	}	
	
	// --------------------------------------------------------------------
	
	/**
	 * Verifica daca in tabelul primit exista deja valoarea $value mai putin cea cu id-ul luat din $params
	 * @param $value -> valoarea ce trebuie cautata
	 * @param $params -> string concatenat din Tabela.camp.id
	 * @return bool
	 */
	function update_unique($value, $params) {

		$CI =& get_instance();
		$CI->load->database();

		$CI->form_validation->set_message('update_unique',
			lang('The %s already exists!'));

		list($table, $field, $id) = explode(".", $params, 3);
		

		$query = $CI->db->select($field)->from(strtolower($table))
			->where($field, $value)->where('id !=', $id)->limit(1)->get();

		if ($query->row()) {			
			return FALSE;
		} else {
			return TRUE;
		}
	}	
		

	
	// --------------------------------------------------------------------
		
	/**
	 * Verifica daca userul/parola sunt corecte
	 * @return unknown_type
	 */
	function verify_login($password, $type = 'user'){
		$CI =& get_instance();
		
		$username	= $CI->input->post('username');
		$password	= $CI->input->post('password');
		$login = $CI->access->login($type, $username, $password);
					
		if($login === 'REJECT') {
			$CI->form_validation->set_message('verify_login', lang('Your account has been suspended.'));
			return FALSE;
			
		} else if($login === 'PENDING') {
			// Throttled authentication
			$CI->form_validation->set_message('verify_login',lang('Your account is pending. Please verify you email and confirm registration!'));
			return FALSE;
		} else if($login === 'TIMEOUT') {
			// Throttled authentication
			$CI->form_validation->set_message('verify_login',lang('Too many attempts. You can try again in 20 seconds.'));
			return FALSE;
		}
		

		if($login) {
			return TRUE;			
		} else {			
			// Wrong username/password combination
			$CI->failure_logins->increment_failures_by_ip(ip2long($CI->input->ip_address()),$CI->failed_logins,$username);
			$CI->form_validation->set_message('verify_login', lang('Invalid user/password'));
			return FALSE;
		}
		
	}
	
	// --------------------------------------------------------------------	
	/**
	 * Verifica daca vechea parola e ok
	 * @param $password
	 * @return unknown_type
	 */
	function old_password_verification($password){
		$CI = & get_instance();
		$salt = $this->CI->config->item('salt');
		
		if(hash('sha256',$salt.$CI->user->hash.$password) !== $CI->user->password){
			$CI->form_validation->set_message('old_password_verification', lang('Invalid old password'));
			return FALSE;
		}
		return TRUE;		
	}
	
	// --------------------------------------------------------------------
	/**
	 * Verifica daca nu cumva userul este rezervat (gen admin, administrator, controller, nume de controllere etc)
	 * @param $username
	 * @return unknown_type
	 */
	function not_restricted($username){
		$CI = &get_instance();
		$predefined_bans = array('performers','contact','studio','performer','tos','terms','admin','administrator','policy',AFFILIATES_URL,PREFORMERS_URL,STUDIOS_URL,ADMINS_URL,'cron','documents','home','import','install','room','upload','uploads','assets',MY_TEMP_PATH);
		
		
		if( in_array($username,$predefined_bans) ){
			$CI->form_validation->set_message(__FUNCTION__,lang('You are not allowed to use this username!'));
			return FALSE;
		}
		return TRUE;
	}
		
	// --------------------------------------------------------------------
	/**
	 * Verifica daca nu cumva userul este rezervat (gen admin, administrator, controller, nume de controllere etc)
	 * @param $username
	 * @return unknown_type
	 */
	function unique_email($email,$type = 'users'){
		$CI = &get_instance();
		
		if( ! EMAIL_UNIQUE ){
			return TRUE;
		}		
				
		if( ! in_array($type,array('users','studios','performers','admins','affiliates')) ){
			$CI->form_validation->set_message(__FUNCTION__ , lang('Invalid data.'));
			return FALSE;				
		}
		$CI->load->model($type);
		
		$email = $CI->$type->get_one_by_email($email);
		
		if( $email ){
			$CI->form_validation->set_message(__FUNCTION__ , lang('Email already exists in our database.'));
			return FALSE;
		}
				
		return TRUE;
	}	
	
	// --------------------------------------------------------------------	
	/**
	 * Verifica daca mailul apartine vreunui utilizator din baza de date
	 * @param $email -> valoarea ce trebuie cautata
	 * @param $table -> tabelul in care trebuei cautat
	 * @author VladG
	 */
	function mail_belog_to_user($email,$table) {
	
		$CI =& get_instance();
		$CI->load->database();

		$CI->form_validation->set_message('mail_belog_to_user',
			lang('invalid user/email'));
	

		$query = $CI->db->select('username')->from($table)
			->where('email', $email)->where('username', $CI->input->post('username'))->limit(1)->get();

		if ($query->row()) {			
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// --------------------------------------------------------------------	
	/**
	* @author	VladG
	* @return Valideaza data nasterii
	*/
	function birthday() {
            
		$CI 	=& get_instance();
        $day    = $CI->input->post('day');
        $month  = $CI->input->post('month');
        $year   = $CI->input->post('year');
            
            
		//Daca data selectata este invalida
		if (0 > $day || $day > 31 || ! is_numeric($day) ) {
			$CI->form_validation->set_message('birthday', lang('Invalid  birthdate'));
			return FALSE;
		}
		
		//Daca luna selectata este invalida
		if (0 > $month || $month > 12  || ! is_numeric($month) ) {
			$CI->form_validation->set_message('birthday', lang('Invalid  birthdate'));
			return FALSE;
		}
            
		//daca anul selectat este invalid
		if (0 > $year || $year > date('Y') || ! is_numeric($year) ) {
			$CI->form_validation->set_message('birthday', lang('Invalid  birthdate'));
			return FALSE;
		}
            
		$birthday = mktime(0, 0, 0, $month, $day, $year);
            
		//Daca data nasterii e mai mica de 18 ani
		if ($birthday > strtotime('-18 years')) {
			$CI->form_validation->set_message('birthday', lang('Invalid  birthdate'));
			return FALSE;
		}
        
		return TRUE;
	}
	
	// --------------------------------------------------------------------	
	/**
	* @author	VladG
	* @return daca numarul este mai mic < 0 si > 100 returneaza true
	*/
	function check_percentage($number) {
		if ( $number < 0 AND  $number > 100) {
			$CI->form_validation->set_message('check_percentage', 'Invalid percentage');
			return false;
		}
		return true;	
	}	

	// --------------------------------------------------------------------	
	/*
	 * Valideaza limbile introduse de catre utilizator
	 * @author Baidoc
	 * @return boolean 
	 */
	function check_language($codes) {		
		
		$CI =& get_instance();
		
		if( sizeof($codes)  == 0 ){
			$CI->form_validation->set_message(__FUNCTION__,lang('Please select at least one language'));
			return FALSE;
		}		
		
		$CI->load->model('supported_languages');		
		$query = $CI->supported_languages->get_supported_languages();
		foreach ($query as $lang_code) {
			$lang_codes[] = $lang_code->code;
		}
			
		$CI->form_validation->set_message('check_language', lang('Invalid  language'));
		foreach ($codes as $code ) {
			if(! in_array($code, $lang_codes) ) {
				return FALSE;
			} 
		}
		
		return TRUE;
	}

	// --------------------------------------------------------------------	
	/* Compara input-ul de la language cu cele din baza de date 
	 * @author VladG
	 * 
	 */
	function check_categories() {		
		
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->model('categories');
		
		$CI->form_validation->set_message('check_categories', lang('Invalid  category/subcategory'));
		
		$categories = $CI->categories->get_all_categories(FALSE);
		foreach ($categories as $category) {
			$lang_codes[] = $category->id;
		}

		foreach($CI->input->post('category') as $cat){
			if( ! in_array($cat,$lang_codes)){
				return FALSE;
			}
		}		
		return TRUE;
	}
	
	/**
	*
	* Valideaza daca userul a fost sau nu de acord cu TOSul
	* @param unknown_type $tos
	* @return boolean
	*/
	function check_tos($tos){
		$CI =& get_instance();
		
		if( ! $tos ) {
			$CI->form_validation->set_message(__FUNCTION__,lang('You must agree with our Terms of Service'));
			return FALSE;
		}
		return TRUE;
	}
		
	// --------------------------------------------------------------------	
	/**
	 * Verifica daca contractul performerului e ok
	 * @return unknown_type
	 */
	function performer_contract($value = '',$type = 'Performer'){
		$CI =& get_instance();
		
		$contracts = $CI->session->userdata('contract');
		
		//arrayu e gol
		if( ! is_array( $contracts) || sizeof($contracts) == 0 ){
			$CI->form_validation->set_message('performer_contract', sprintf(lang('%s contract inexistent/invalid'),$type));
			return FALSE;
		}

		$existing_contracts = array();
		
		$CI->load->helper('images');
		
		//iau doar fisierele ce exista pe disk
		foreach( $contracts as $contract ){
			if(  file_exists( BASEPATH.'../'.MY_TEMP_PATH.'/' . $contract['file_on_disk_name'] ) && check_for_valid_type( BASEPATH.'../'.MY_TEMP_PATH.'/' . $contract['file_on_disk_name'] ) ){
				array_push($existing_contracts,$contract);					
			} 			
		}

		//nu e nici un contract bun
		if( sizeof($existing_contracts) == 0 ){
			$CI->session->set_userdata('contract',$existing_contracts);				
			$CI->form_validation->set_message('performer_contract', sprintf(lang('%s contract inexistent/invalid'),$type));
			return FALSE;
		}

		$CI->good_contracts = $existing_contracts;
		return TRUE;
	}

	// --------------------------------------------------------------------
	/**
	 * Valideaza buletinele
	 * @return unknown_type
	 */
	function performer_photo_id(){
		$CI =& get_instance();
		
		$photo_ids = $CI->session->userdata('photo_id');
		
		//arrayu e gol
		if( ! is_array( $photo_ids) || sizeof($photo_ids) == 0 ){
			$CI->form_validation->set_message(__FUNCTION__, lang('Performer photo ID inexistent/invalid'));
			return FALSE;
		}

		$existing_photo_ids = array();
		
		$CI->load->helper('images');
		
		//iau doar fisierele ce exista pe disk
		foreach( $photo_ids as $photo_id ){
			if(  file_exists( BASEPATH.'../'.MY_TEMP_PATH.'/' . $photo_id['file_on_disk_name'] ) && check_for_valid_type( BASEPATH.'../'.MY_TEMP_PATH.'/' . $photo_id['file_on_disk_name'] ) ){
				array_push($existing_photo_ids,$photo_id);					
			} 			
		}

		//nu e nici un contract bun
		if( sizeof($existing_photo_ids) == 0 ){
			$CI->form_validation->set_message(__FUNCTION__, lang('Performer photo ID inexistent/invalid'));
			$CI->session->set_userdata('photo_id',$existing_photo_ids);				
			return FALSE;
		}

		$CI->good_photo_ids = $existing_photo_ids;
		return TRUE;		
	}
	
	
	// --------------------------------------------------------------------	
    /**
     * Checks if a given avatar is valid.
     * @reutrn boolean
     */
    function performer_photo() {
        $CI     =& get_instance();
        $photos = $CI->session->userdata('photos');

        if (!is_array($photos) || sizeof($photos) == 0) {
            $CI->form_validation->set_message('performer_photo', lang('Photo does not exist.'));
            return FALSE;
        }
        $existing_photos = array();
        $CI->load->helper('images');
		foreach($photos as $photo) {
			if(file_exists(BASEPATH.'../'.MY_TEMP_PATH.'/' . $photo['file_on_disk_name']) && check_for_valid_image(BASEPATH.'../'.MY_TEMP_PATH.'/' . $photo['file_on_disk_name'])) {
				array_push($existing_photos, $photo);					
			} 			
		}
		if(sizeof($existing_photos) == 0) {
            $CI->form_validation->set_message('performer_photo', lang('Photo does not exist.'));
            $CI->session->set_userdata('photos',$existing_photos);            
			return FALSE;
		}
		$CI->good_photos = $existing_photos;
        return TRUE;
    }
    
    
	// --------------------------------------------------------------------    
    /**
     * Checks if a given avatar is valid.
     * @reutrn boolean
     */
    function performer_avatar() {
        $CI     =& get_instance();
        
        $photos = $CI->session->userdata('avatar');
        if ( ! is_array($photos) || sizeof($photos) == 0) {
            //$CI->form_validation->set_message('performer_avatar', lang('Avatar does not exist.'));
            return TRUE;
        }
        
        $existing_photos = array();
        $CI->load->helper('images');
		foreach($photos as $photo) {
			if(file_exists(BASEPATH.'../'.MY_TEMP_PATH.'/' . $photo['file_on_disk_name']) && check_for_valid_image(BASEPATH.'../'.MY_TEMP_PATH.'/' . $photo['file_on_disk_name'])) {
				array_push($existing_photos, $photo);
				break;					
			} 			
		}
		
		if( sizeof($existing_photos) == 0 ) {
			$CI->session->set_userdata('avatar',$existing_photos);				
            $CI->form_validation->set_message('performer_avatar', lang('Avatar does not exist.'));
			return FALSE;
		}
		$CI->good_avatar = $existing_photos;
        return TRUE;
    }

    // --------------------------------------------------------------------
    /**
     * Verifica daca release amountul e cel putin valoarea setata de admin
     * @param unknown_type $amount
     * @return boolean
     * @author Baidoc
     */
    function valid_release_amount($amount){
    	$CI = & get_instance();
    	
    	$payment_method_id = $CI->input->post('payment_method');

    	$CI->load->model('payment_methods');
    	
    	$payment_method = $CI->payment_methods->get_one_by_id($payment_method_id);
    	
    	if( ! $payment_method){
    		$CI->form_validation->set_message(__FUNCTION__, lang('Invalid payment method'));
    		return FALSE;
    	}
    	if( $payment_method->minim_amount > $amount ){
    		$CI->form_validation->set_message(__FUNCTION__, sprintf(lang('Release amount cannot be under %s %s'), $payment_method->minim_amount,SETTINGS_SHOWN_CURRENCY));    		
    		return FALSE;
    	}
	
    	return TRUE;
    	
    }
    
	// --------------------------------------------------------------------   
    /**
     * Verifica daca pretul ales este valid
     * @param $price
     * @param $type
     * @return unknown_type
     */
    function valid_price($price,$type){    	
    	$CI = &get_instance();    	
		if($price > constant( 'MAX_' . strtoupper($type) . '_CHIPS_PRICE') ){
			$CI->form_validation->set_message('valid_price', sprintf( lang('%s chips cannot be set more then %s credits'),  ucfirst(preg_replace('/_/', ' ', $type)), constant( 'MAX_' . strtoupper($type) . '_CHIPS_PRICE') ) );
			return FALSE;
		}
		
		if($price < constant( 'MIN_' . strtoupper($type) . '_CHIPS_PRICE') ){
			$CI->form_validation->set_message('valid_price', sprintf( lang('%s chips cannot be set less then %s credits'),ucfirst(preg_replace('/_/', ' ', $type)), constant( 'MIN_' . strtoupper($type) . '_CHIPS_PRICE')) );
			return FALSE;
			
		}

		return TRUE;
    }
    
    // --------------------------------------------------------------------    
    /**
     * Checks if a given status is valid.
     * @param status
     * @return boolean
     */
    function valid_status($status) {
        $CI =& get_instance();
        return in_array($status, array('none', 'approved', 'pending', 'rejected'));
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * Verifica daca valoarea introdusa coincide cu cele din baza de date
     * @param $value -> valoarea ce trebuie comparata
     * @param $table -> tabelul in care trebuei cautat
     * @author VladG
     */
	function valid_enum_value($value, $field){
		
		$model = 'performers_profile';
		if(strpos($field,'.') !== FALSE){
			list($model,$field) = explode('.',$field);
		}
		
		$CI =& get_instance();
		$CI->load->model($model);
		
		$enum_values = $CI->$model->get_enum_values($field);
		
		if( ! in_array($value,$enum_values)){
			$CI->form_validation->set_message(__FUNCTION__,sprintf(lang('invalid %s'),lang($field)));
			return FALSE;
		}
		
		return TRUE;
	}

    
	// --------------------------------------------------------------------
	
	/**
	 * Verifica daca valoarea introdusa coincide cu cele din baza de date
	 * @param $value -> valoarea ce trebuie comparata
	 * @param $table -> tabelul in care trebuei cautat
	 * @author VladG
	 */
	function valid_state($value){
		$CI =& get_instance();
		
		$enum_values = $CI->config->item('states');
		
		if( ! key_exists($value,$enum_values)){
			$CI->form_validation->set_message(__FUNCTION__,sprintf(lang('invalid %s'),lang($field)));
			return FALSE;
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	/**
	 * Verifica daca countryul introdus e valid 
	 * @param $country
	 * @return unknown_type
	 */
	function valid_country($country){
		$CI = & get_instance();
		
		$CI->load->config('regions');
		
		$countries = $CI->config->item('countries');
		
		if( ! key_exists($country, $countries)){
			$CI->form_validation->set_message(__FUNCTION__,lang('invalid country'));
			return FALSE;
		}
		
		return TRUE;
	}

	// --------------------------------------------------------------------
		
	/**
	 * Verifica daca tipul de contact e valid
	 * @param $type
	 * @return unknown_type
	 */
	function valid_type($type){
		$CI = & get_instance();
		if($type == 0){
			$CI->form_validation->set_message('valid_type',lang('Please choose the type'));
			return FALSE;
		}

		if( ! key_exists($type,$CI->config->item('types'))){
			$CI->form_validation->set_message('valid_type',lang('Invalid type'));
			return FALSE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------	
	/**
	 * Verifica daca tipul de video selectat e valid
	 * @param $type
	 * @return unknown_type
	 */
	function valid_video_type($type){
		$CI = & get_instance();
		
		if( ! key_exists($type, $CI->video_types) ){
			$CI->form_validation->set_message('valid_video_type',lang('Invalid video type'));
			return FALSE;
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------		
	/**
	 * Verifica daca pretul pentru video e setat corect
	 * @param $price
	 * @return unknown_type
	 */
	function valid_video_price($price){
		$CI = & get_instance();
		
		
		//tipul selectat e FREE
		if( $CI->input->post('type') == 0){
			return TRUE;
		}
		
		if( $price < MIN_PAID_VIDEO_CHIPS_PRICE ){
			$CI->form_validation->set_message('valid_video_price',sprintf(lang('Video price cannot be lower than %s chips'),MIN_PAID_VIDEO_CHIPS_PRICE));
			return FALSE;
		}
		
		if( $price > MAX_PAID_VIDEO_CHIPS_PRICE ){
			$CI->form_validation->set_message('valid_video_price',sprintf(lang('Video price cannot be greater than %s chips'),MAX_PAID_VIDEO_CHIPS_PRICE));
			return FALSE;
		}
		
		return TRUE;
	}

	// --------------------------------------------------------------------
	/**
	 * Verifica daca itemul apartine vreunui camp din baza de date
	 * @param $item_name -> valoarea ce trebuie cautata
	 * @param $param -> prima valoare este tabelul in care cauta , iar a doua valoare este id
	 * @author VladG
	 */
	function valid_item($value, $param){
		$CI =& get_instance();
		list($table, $field) = explode(".", $param, 2);
				
		$query = $CI->db->select($field)->from(strtolower($table))
			->where($field, $value)->limit(1)->get()->row();
		
		if( ! $query ){
			$CI->form_validation->set_message(__FUNCTION__,lang('invalid %s',lang(strtolower($table))));
			return FALSE;	
		}
		return TRUE;
	}	
	
	// --------------------------------------------------------------------	
	/**
	 * Valideaza folderul pt messenger
	 * @param $folder - folderul dorit
	 * @author Baidoc
	 */
	function valid_message_folder($folder){
		$CI =& get_instance();
				
		if( ! in_array($folder, $CI->folders)){
			$CI->form_validation->set_message(__FUNCTION__,lang('invalid folder'));	
			return FALSE;
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	/**
	 * Valideaza daca e sau nu valid message_idul
	 * @param unknown_type $message_id
	 * @author Baidoc
	 */	
	function valid_message_id($message_id){
		$CI =& get_instance();
		
		$sent = (isset($CI->sent)?$CI->sent:FALSE);
		
		$message = $CI->messages->get_one_by_message_id($message_id,$sent);
		if( ! $message ){
			$CI->form_validation->set_message(__FUNCTION__,lang('invalid message id'));
			return FALSE;
		}
		
		$CI->message = $message;
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	/**
	 * Valideaza daca procentajul setat de studio e valid
	 * @param unknown_type $percentage
	 * @author Baidoc
	 */
	function valid_studio_percentage($percentage){
		
		$CI =& get_instance();
		
		if( $percentage < 1){
			$CI->form_validation->set_message(__FUNCTION__,sprintf(lang('Percentage cannot be lower than %s'), '1' ));	
			return FALSE;
		}
		
		if( $percentage > 99){
			$CI->form_validation->set_message(__FUNCTION__,sprintf(lang('Percentage cannot be more than %s'), '99' ));
			return FALSE;
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	/**
	 * Valideaza un input sa nu contina caractere aiurea
	 * @param unknown_type $field
	 * @return boolean
	 * @author Baidoc
	 */
	function valid_post_field($field){
		
		$CI =& get_instance();
		
		if ( ! preg_match("|^[".str_replace(array('\\-', '\-'), '-', preg_quote($CI->config->item('permitted_uri_chars'), '-'))."]+$|i", $field))
		{
			$CI->form_validation->set_message(__FUNCTION__,lang('Field names can contain just alphanumeric values'));
			return FALSE;
		}
		
		return TRUE;
		
	}
	// --------------------------------------------------------------------
	
	/**
	 * Puryfies the html code
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	
	function purify($dirty_html){
		
		if (is_array($dirty_html))
		{
			foreach ($dirty_html as $key => $val)
			{
				$dirty_html[$key] = purify($val);
			}
		
			return $dirty_html;
		}
		// to prevent further processing of 'nothing'...
		if (trim($dirty_html) === '')
		{
			return $dirty_html;
		}
		
		
		require_once(APP_DEFAULT_PATH . 'libraries/HTMLPurifier.auto.php');
		require_once(APP_DEFAULT_PATH . 'libraries/HTMLPurifier.func.php');

		$config = HTMLPurifier_Config::createDefault();

		$config->set('HTML.Doctype', 'XHTML 1.0 Strict');
		
		return HTMLPurifier($dirty_html, $config);		
//		return $this->CI->htmlpurifier->purify( $dirty_html , $this->conf );
	}
	
	
	/**
	* Validare melodie
	* @author Baidoc
	*/
	function has_uploaded_music(){
		$CI = & get_instance();
	
		$config['upload_path'] = './uploads/stuff/';
		$config['allowed_types'] = 'mp3';
		$config['max_size']	= 99999999;
	
		$CI->load->library('upload', $config);
	
		if ( ! $CI->upload->do_upload())
		{
			$CI->form_validation->set_message(__FUNCTION__,$CI->upload->display_errors());
			return FALSE;
		}
	
		$CI->image_data = $CI->upload->data();
		return TRUE;
	}
	
	
}
