<?php
Class Performers extends CI_Model{

	var $performers 			= 'performers';
	var $performers_profile 	= 'performers_profile';
	var $performers_photos 		= 'performers_photos';
	var $performers_videos 		= 'performers_videos';
	var $performers_categories 	= 'performers_categories';
	var $performers_languages	= 'performers_languages';
	var $performers_favorites	= 'performers_favorites';
	var $fms					= 'fms';
	var $user_id				= 'user_id';

	##################################################################################################
	############################################# GET ################################################
	##################################################################################################


	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa $id
	 * @param $id
	 * @return object
	 */
	function get_one_by_id($id){
		return $this->db->where('id',$id)->set_memcache_key('performer_id-%s',array($id),100)->limit(1)->get($this->performers)->row();
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un user dupa username
	 * @param $username
	 * @return unknown_type
	 */
	function get_one_by_username($username){
		return $this->db->where('username',$username)->limit(1)->get($this->performers)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza detaliile unui performer dupa nickname
	 * @param $nickname
	 * @param $user_id
	 * @return unknown_type
	 */
	function get_one_by_nickname($nickname,$user_id = FALSE){
		$this->db->select('*,performers.status as status, performers.fms_id as fms_id,performers_profile.description as description');
		$this->db->where('nickname',$nickname)
					->join($this->performers_profile	, $this->performers_profile 	. '.performer_id = ' . $this->performers . '.id'		,'inner')
					->join($this->performers_languages	, $this->performers_languages	. '.performer_id = ' . $this->performers . '.id'		,'inner')
					->join($this->performers_categories	, $this->performers_categories 	. '.performer_id = ' . $this->performers . '.id'		,'left');

		if( $user_id > 0 ){
			$this->db->join($this->performers_favorites,'( performers.id = ' . $this->performers_favorites . '.performer_id AND '. $this->performers_favorites . '.user_id = '.$this->db->escape($user_id),'left');
		}

		$query = $this->db->get($this->performers);

		// Convenience - they aren't really related in this way
		$result = array(
			'profile'	=> $query->result(),
			'performer'	=> $query->row()
		);

		return $result;

	}


	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa email
	 * @param $email
	 * @return unknown_type
	 */
	function get_one_by_email($email){
		return $this->db->where('email',$email)->limit(1)->get($this->performers)->row();
	}


	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza rateul unui performer
	 * @param unknown_type $performer_id
	 * @return string
	 * @author Baidoc
	 */
	function get_performer_rate_details($performer_id){
		return $this->db->select('AVG(`rating`) as `rating`, COUNT(`rating`) as `votes`')->where('performer_id', $performer_id)->get('performers_reviews')->row();
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un array cu performeri
	 * @param $filters array
	 * @param $limit int
	 * @param $offset int
	 * @param $order_by array
	 * @param $count bool
	 * @return array
	 */
	function get_multiple_performers($filters = array(),$limit = 10,$offset = 0,$order_by = array('performers.id'=>'ASC'),$count = FALSE){
		//filtrele nu au fost purificate
		if( ! $this->is_purified  ){
			show_error('Invalid filters applied');
		}

		$this->db->join($this->performers_languages, $this->performers_languages . '.performer_id = ' . $this->performers . '.id','inner');

		//performerii trebuie sa fie aprobati
		$this->db->where('status', 'approved');

		//filtru de performeri in privat sau nu
		if( isset( $filters['is_in_private'] ) && $filters['is_in_private']  == 0 ){
			$this->db->where('( (is_in_private = 1 AND is_online_type = \'private\' AND enable_peek_mode = 1) OR is_in_private = 0 OR is_online_type != \'private\' )');
		} elseif ( isset( $filters['is_in_private'] ) && $filters['is_in_private'] == 1){
			$this->db->where('is_in_private',1);
		}

		//filtru pt performerii online
		if(isset( $filters['is_online'] ) ){
			$this->db->where('is_online',1);
		}

		//filtru pt performerii online
		$this->db->where('photo_id_status','approved');

		//filtru pt performerii online
		$this->db->where('contract_status','approved');


		//filtru search dupa nume
		if( isset( $filters['nickname'] ) && strlen( $filters['nickname'][0] )  > 0) {
			$this->db->like('nickname',$filters['nickname'][0]);
		}

		//verific daca trebuie sa fac join in tabela de profil
/*		if( isset( $filters['age_range'] ) || isset( $filters['weight'] ) || isset( $filters['height'] ) || isset( $filters['gender'] )
				|| isset( $filters['ethnicity'] ) || isset( $filters['eye_color'] ) || isset( $filters['build'] ) || isset( $filters['sexual_prefference'] )
				|| isset( $filters['hair_color'] ) || isset( $filters['hair_length'] ) ){
			$this->db->join($this->performers_profile,$this->performers_profile . '.performer_id = ' . $this->performers . '.id', 'inner');
		}*/
		$this->db->join($this->performers_profile,$this->performers_profile . '.performer_id = ' . $this->performers . '.id', 'inner');

		//filtru pe categori
		if(isset($filters['category'])){
			$this->db->join($this->performers_categories,$this->performers_categories . '.performer_id = ' . $this->performers . '.id','inner');
			$this->db->join('categories',$this->performers_categories . '.category_id = categories.id','inner');
			$this->db->where_in('categories.link',$filters['category']);
		}

		//filtru pe varsta
		if(isset($filters['age_range'])){
			@list($start,$stop) = explode('-', $filters['age_range'][0]);


			//daca e definita data maxima
			if( $stop ){
				if($start >= 18) { //daca sunt extreme nu are rost sa fie incluse in interogare
					$this->db->where('birthday <= ' , strtotime((int)$start . ' years ago') );
				}
				if($stop != 50 && $stop >= $start) {
					$this->db->where('birthday >= ' , strtotime((int)$stop . ' years ago') );
				}
			}
		}

		//filtru pe greutate
		if(isset($filters['weight'])){
			$this->db->where_in('weight',$filters['weight']);
		}

		//filtru pe inaltime
		if(isset($filters['height'])){
			$this->db->where_in('height',$filters['height']);
		}

		//filtru pe gen
		if(isset($filters['gender'])){
			$this->db->where_in('gender',$filters['gender']);
		}

		//filtru pe etnie
		if(isset($filters['ethnicity'])){
			$this->db->where_in('ethnicity',$filters['ethnicity']);
		}

		//filtru pe culoarea ochilor
		if(isset($filters['eye_color'])){
			$this->db->where_in('eye_color',$filters['eye_color']);
		}

		//filtru pe build
		if(isset($filters['build'])){
			$this->db->where_in('build',$filters['build']);
		}

		//filtru pe preferintele sexuale
		if(isset($filters['sexual_prefference'])){
			$this->db->where_in('sexual_prefference',$filters['sexual_prefference']);
		}

		//filtru pe culoarea parului
		if(isset($filters['hair_color'])){
			$this->db->where_in('hair_color',$filters['hair_color']);
		}

		//filtru pe lungimea parului
		if(isset($filters['hair_length'])){
			$this->db->where_in('hair_length',$filters['hair_length']);
		}


		//filtru pe limbile vorbite
		if(isset($filters['language'])){
			$this->db->where_in('language_code',$filters['language']);
		}

		if(isset($filters['studio_id'])){
			$this->db->where('studio_id',$filters['studio_id']);
		}

		//filtru pe limbile pret
		if(isset($filters['price_range'])) {
			@list($min_price,$max_price) = explode('-', $filters['price_range'][0]);

			if( $max_price ) {//daca e setat pretul maxim
				if($min_price > MIN_PRIVATE_CHIPS_PRICE) {
					$this->db->where('private_chips_price >=', $min_price);
				}
				if($max_price < MAX_PRIVATE_CHIPS_PRICE && $max_price >= $min_price ) {
					$this->db->where('private_chips_price <=', $max_price);
				}
			}
		}

		if($count){
			$this->db->select('count(distinct(performers.id)) as total');

			if( isset( $filters['country_code'] ) ){
				$this->db->where('(SELECT COUNT(performer_id) FROM `banned_countries` WHERE `banned_countries`.`performer_id` = `performers`.`id` AND `banned_countries`.`country_code` =  '.$this->db->escape($filters['country_code']).') = 0');
			}

			//filtru pe statul de origine (ban pe stat)
			if( isset( $filters['state_code'] ) ){
				$this->db->where('(SELECT COUNT(performer_id) FROM `banned_states` WHERE `banned_states`.`performer_id` = `performers`.`id` AND `banned_states`.`state_code` =  '.$this->db->escape($filters['state_code']).') = 0');
			}

			return $this->db->get($this->performers)->row()->total;
		} else {
			$this->db->select('distinct(performers.id), performers.* , performers_profile.* ,group_concat(language_code) as language_code ');

			//filtru pe tara de origine (ban pe tara)
			if( isset( $filters['country_code'] ) ){
				$this->db->having('(SELECT COUNT(performer_id) FROM `banned_countries` WHERE `banned_countries`.`performer_id` = `performers`.`id` AND `banned_countries`.`country_code` =  '.$this->db->escape($filters['country_code']).') = 0');
			}

			//filtru pe statul de origine (ban pe stat)
			if( isset( $filters['state_code'] ) ){
				$this->db->having('(SELECT COUNT(performer_id) FROM `banned_states` WHERE `banned_states`.`performer_id` = `performers`.`id` AND `banned_states`.`state_code` =  '.$this->db->escape($filters['state_code']).') = 0');
			}

			if(isset($order_by['is_online'])){
				$this->db->order_by('is_online',$order_by['is_online']);
			}

			//selectare performeri favoriti
			if( isset( $filters['user_id'] ) ){
				$this->db->select($this->performers_favorites . '.favorite_id');
				$this->db->join($this->performers_favorites, $this->performers_favorites . '.favorite_id = ' . $this->performers . '.id and `user_id` = '.$filters['user_id'],'left');
				if(isset($order_by['favorite_id'])){
					$this->db->order_by('favorite_id',$order_by['favorite_id']);
				}
			}

			if(isset($order_by['mark'])){
				$this->db->order_by('mark',$order_by['mark']);
			}

			if(isset($order_by['rand'])){
				$this->db->order_by('rand()');
			}

			$this->db->group_by('performers.id');
			$this->db->limit($limit);
			$this->db->offset($offset);

			return $this->db->get($this->performers)->result();
		}
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza cati performeri is online pe fiecare fms
	 * @return array
	 */
	function get_multiple_count_grouped_by_fms(){
		return $this->db->select('count(id) as number,fms_id')->group_by('fms_id')->get($this->performers)->result();
	}


	/**
	 *
	 * Returneaza performerii pentru cronu de plati ce nu au id si au credite
	 * @author Baidoc
	 */
	function get_multiple_performers_for_payments_cron(){
		return $this->db->where('studio_id IS NULL')->where('credits > 0')->get($this->performers)->result();
	}
	// -----------------------------------------------------------------------------------------
	/**
	 *
	 * Returneaza performerii favoriti a unui user id , cu ban pe tara
	 * @param unknown_type $user_id
	 * @param unknown_type $filters
	 * @param unknown_type $limit
	 * @param unknown_type $offset
	 * @param unknown_type $count
	 * @author Baidoc
	 */
	function get_multiple_favorite_performers_by_user_id($user_id,$filters = array(), $limit = FALSE,$offset = FALSE,$count = FALSE) {
		if($count){
			$this->db->select('count(performers.id) as total');
		}

		$this->db->join($this->performers_languages, $this->performers_languages . '.performer_id = ' . $this->performers_favorites . '.performer_id','inner');

		$this->db->where('user_id', $user_id)->join('performers', 'performers.id = performers_favorites.performer_id','inner');

		if($count){

			if( isset( $filters['country_code'] ) ){
				$this->db->where('(SELECT COUNT(performer_id) FROM `banned_countries` WHERE `banned_countries`.`performer_id` = `performers`.`id` AND `banned_countries`.`country_code` =  '.$this->db->escape($filters['country_code']).') = 0');
			}

			//filtru pe statul de origine (ban pe stat)
			if( isset( $filters['state_code'] ) ){
				$this->db->where('(SELECT COUNT(performer_id) FROM `banned_states` WHERE `banned_states`.`performer_id` = `performers`.`id` AND `banned_states`.`state_code` =  '.$this->db->escape($filters['state_code']).') = 0');
			}

			return $this->db->get($this->performers_favorites)->row()->total;
		} else {
			$this->db->select('distinct(performers.id), performers.* ,group_concat(language_code) as language_code ');
			$this->db->group_by('performers.id');

			//filtru pe tara de origine (ban pe tara)
			if( isset( $filters['country_code'] ) ){
				$this->db->having('(SELECT COUNT(performer_id) FROM `banned_countries` WHERE `banned_countries`.`performer_id` = `performers`.`id` AND `banned_countries`.`country_code` =  '.$this->db->escape($filters['country_code']).') = 0');
			}

			//filtru pe statul de origine (ban pe stat)
			if( isset( $filters['state_code'] ) ){
				$this->db->having('(SELECT COUNT(performer_id) FROM `banned_states` WHERE `banned_states`.`performer_id` = `performers`.`id` AND `banned_states`.`state_code` =  '.$this->db->escape($filters['state_code']).') = 0');
			}

			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get($this->performers_favorites)->result();
		}
	}

	##################################################################################################
	############################################ UPDATE ##############################################
	##################################################################################################

	/**
	 * Adauga credite unui performer
	 * @param $performer_id
	 * @param $credits
	 * @return unknown_type
	 */
	function add_credits($performer_id,$credits){
		$p = $this->get_one_by_id($performer_id);
		fwrite(fopen(APPPATH.'/logs/performers.txt', 'a'), "\n\n\n ADD {$performer_id} CU {$credits} CAND AVEA ".$p->credits);
		$this->db->drop_memcache_key('performer_id-%s',array($performer_id));
		$this->db->query('UPDATE `performers` SET `credits` = `credits` + ' . $this->db->escape($credits) . ' WHERE `id` = ' . $this->db->escape($performer_id) );
	}


	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza proprietatile unui performer dupa performer id
	 * @param $performer_id
	 * @param $changes array CAMP => valoare
	 * @return unknown_type
	 */
	function update($performer_id,$changes){
		if($this->db->where('id',$performer_id)->drop_memcache_key('performer_id-%s',array($performer_id))->set($changes)->update($this->performers)){
			return TRUE;
		}
		return FALSE;
	}


	##################################################################################################
	############################################ DELETE ##############################################
	##################################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Verifica daca performerul poate intra in tipul de chat dorit de user
	 * @param $performer
	 * @param $wanted_type
	 * @return bool
	 */
	function allowed_chat_type($performer,$wanted_type){
		//keia e statusul performerului, valorile in ce tip de chat poate intra
		$good_types = array(
			'free'=>array('free','private'),//performerul in free poate intra in free sau private chat
			'nude'=>array('nude'),
			'peek'=>array('private'),
			'private'=>array('private','peek')
		);

		if( ! isset ( $good_types[$performer->is_online_type] ) ){//nu e facuta setarea pt tipul de chat cerut
			return FALSE;
		}

		if( ! in_array($wanted_type,$good_types[$performer->is_online_type])){
			return FALSE;
		}

		if($wanted_type === 'private' && $performer->is_in_private){
			return FALSE;
		}

		if($wanted_type === 'peek' && ! $performer->enable_peek_mode){//performerul nu accepta PEEK
			return FALSE;
		}

		return TRUE;
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Genereaza subquery pt filtrare pe ani
	 * @param $filters
	 * @return unknown_type
	 */
	function generate_age_filter($filters){
		$where = NULL;
		$count = count($filters); //$filters['age_range']
		if($count > 1){
			$where .= "(";
		}
		$i = 0;
		foreach ($filters as $value){
			$years	= explode('-', $value);
			$start	= date('Y-m-d', strtotime("-$years[0] year"));
			$end	= date('Y-m-d', strtotime("-$years[1] year"));

			if($count > 1){
				if($i == ($count - 1)){
					$where .= " (`birthday` BETWEEN {$start} AND {$end}) )";
				} else {
					$where .= " (`birthday` BETWEEN {$start} AND {$end}) OR";
				}
				$i++;
			} else {
				$where .= "`birthday` BETWEEN {$start} AND {$end}";
			}
		}

		return $where;
	}


	// -----------------------------------------------------------------------------------------
	/**
	 * Valideaza un performer
	 */
	function valid_performer($performer){
		if( ! preg_match("/^([a-z0-9_-])+$/i", $performer)){
			return FALSE;
		}
		return TRUE;
	}


	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza pretu pe minut pentru tipul de chat dorit pt un performer
	 * @param $performer
	 * @param $chat_type
	 * @return unknown_type
	 */
	function get_fee_per_minute($performer,$chat_type){
		switch($chat_type){
			case 'nude' :
					return $performer->nude_chips_price;
			case 'peek':
					return $performer->peek_chips_price;
			case 'private':
					return $performer->private_chips_price;
			case 'true_private':
					return $performer->true_private_chips_price;
			default:
					return 0;
		}
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza butoane dupa caz, daca performerul e online,offlin,private chat... etc.
	 * @param $performer
	 */
	function display_buttons($performer) {

		$performer_online = array(
			'free_chat' 	=> array(
										'name' => lang('FREE CHAT'),
										'link' => site_url('room/' . $performer->nickname )
									),
			'private_chat'	=> array(
										'name' => lang('PRIVATE CHAT'),
										'require_login' => 1,
										'link' => site_url('/room/' . $performer->nickname . '/private')
									)
		);

		$performer_offline = array(
			'my_profile' => array(
										'name' => lang('MY PROFILE'),
										'require_login' => 0,
										'link' => site_url($performer->nickname)
								)
		);

		$chat_nude = array(
			'nude_chat'		=> array(
										'name' => lang('NUDE CHAT'),
										'require_login' => 1,
										'link' => site_url('room/' . $performer->nickname . '/nude')
									),
			'my_profile'	=> array(
										'name' => lang('MY PROFILE'),
										'require_login' => 0,
										'link' => site_url($performer->nickname)
									)
		);
		$chat_peek = array(

			'peek_chat'		=> array(
										'name' => lang('PEEK SHOW'),
										'require_login' => 1,
										'link' => site_url('room/' . $performer->nickname . '/peek')
									),
			'my_profile'	=> array(
										'name' => lang('MY PROFILE'),
										'require_login' => 0,
										'link' => site_url($performer->nickname)
									)
		);
		$chat_private = array(
			'private_chat'	=> array(
										'name' => lang('PRIVATE CHAT'),
										'require_login' => 1,
										'link' => site_url('/room/' . $performer->nickname . '/private')
									),
			'my_profile'	=> array(
										'name' => lang('MY PROFILE'),
										'require_login' => 0,
										'link' => site_url($performer->nickname)
									)
		);

		if($performer->is_online == 1 &&  $performer->is_online_type == 'free') {
			return $performer_online;
		}
		if($performer->is_online == 0 ) {
			return $performer_offline;
		}
		if($performer->is_online_type == 'nude' ) {
			return $chat_nude;
		}
		if($performer->is_online_type == 'private' && $performer->is_in_private == 0) {
			return $chat_private;
		}
		if($performer->is_online_type == 'private' && $performer->is_in_private == 1 && $performer->enable_peek_mode == 1) {
			return $chat_peek;
		}
		return $performer_offline;
	}

}