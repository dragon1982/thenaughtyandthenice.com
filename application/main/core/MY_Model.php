<?php
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $firephp
 * @property CI_DB_active_record $db
 * @property System_logs $system_logs
 */
class MY_Model extends CI_Model {

	private $table;
	protected $fields; //array
	protected $join_options = array('right outer','left outer','left','right','inner'); //array
	protected $default_join_option = 'left';
	protected $join_table = array();
	protected $join_table_fields = array();
	protected $whereConditions = '/(!=\s|<=\s|>=\s|<\s|>\s|OR IS NULL|IS NULL|OR IS NOT NULL|IS NOT NULL|OR LIKE\s|OR NOT LIKE\s|NOT LIKE\s|OR\s|AND\s|LIKE\s)/';
	protected $where_types = array('not_like'=>'NOT LIKE','or_not_like'=>'OR NOT LIKE','or_like'=>'OR LIKE','like'=>'LIKE','or_where'=>'OR', 'and_where'=>'AND');
	protected $return_nr = false;
	public function __construct() {
		parent::__construct();
	}

	protected function set_table($table) {
		$this->table = $table;
		$this->get_fields();
	}

	function get_fields($table = FALSE, $return = FALSE){
		if(!$table){
			$table = $this->table;
		}
		$fields = $this->db->list_fields($table);
		
		if(!$return){
			$this->fields[$table] = $fields;
			//$this->fields = $fields;
		}else{
			return $fields;
		}
	}
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza enumurile valide dintrun camp
	 * @param $field
	 * @return unknown_type
	 */
	
	function get_enum_values($field){
		$enum_string = $this->db->query("SELECT COLUMN_TYPE
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE TABLE_NAME = '{$this->table}'
				AND COLUMN_NAME = ". $this->db->escape($field)."
			")->row()->COLUMN_TYPE;
	
		preg_match_all("{'([^'']*)'}si",$enum_string, $enum_array);
	
		return $enum_array[1];
	}
	
	
	
	function table_exist($table){
		return $this->db->table_exists($table);
	}

	
	public function get_by_id($id) {
		$id = abs(intval($id));
		return $this->db->where('id',$id)->get($this->table)->row();
	}

	public function get_rand($many = 1){
		$many = abs((int)$many);
		return $this->db->order_by('RAND()')->offset(0)->limit($many)->get($this->table)->row();
	}


	public function save($rows){
		if(!is_array($rows) || count($rows) == 0){
			return FALSE;
		}

		if(isset($rows['id']) && $rows['id'] > 0){
			$this->db->update($this->table, $rows, array("id" => $rows['id']));
			return $rows['id'];
		}else{
			$this->db->insert($this->table, $rows);
			return $this->db->query("select last_insert_id() id")->row()->id;
		}
	}


	function delete($id){
		$this->db->trans_start();
		$this->db->delete($this->table, array("id" => $id));
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			return FALSE;
		}
		return TRUE;
	}
	

	
	function get_enums_field( $column = FALSE ){
		
		if(!$column){
			return FALSE;
		}
		
		if(in_array($column, $this->fields[$this->table])){
			$row = $this->db->query(" SHOW COLUMNS FROM `$this->table` LIKE '$column' ")->row()->Type;
			$regex = "/'(.*?)'/";
			preg_match_all( $regex , $row, $enum_array );
			$enum_fields = $enum_array[1];
			
			if(is_array($enum_fields) && count($enum_fields) > 0){
				return $enum_fields;
			}else{
				return FALSE;
			}
		}
		
		return FALSE;
		
	}  
	
	
	
	/**
	 *
	 * @param array $filters	$filters['column'] = 'value';
	 * @param boolean $count    Return number of total results
	 * @param string $order     
	 * @param integer $offset
	 * @param integere $limit
	 * @return mixed  array or integer
	 *
	 *
	 * Exemple:
	 *	$this->load->model('channels');
	 * $filters = array(
	 *					'id' => '> 2',
	 *					'userId' => array(
	 *								'6',
	 *								'12'
	 *								'IS NOT NULL',
	 *								'OR IS NOT NULL'
	 *								)
	 *					'addDate' =>array(
	 *								'BETWEEN'=>array('1296561460', '1296727844')
	 *								),
	 *					'name' => array('LIKE esss', 'OR NOT LIKE deee', 'OR test'),
	 *					'embedCode' => 'OR NOT LIKE embed code',
	 *					'isOnline' => 'OR 1',
	 *					'group_by' => 'category_id',
	 *					'join' => array('users' => 'id = user_id, inner'), //view ex. 2   support multiple joins
	 *					'users.name' => 'OR LIKE jhon'
	 * 
	 *			);
	 *
	 *
	 *	$this->channels ->get_all($filters);
	 *
	 * EX: 1.
	 * RESULT: SELECT *
	 *			FROM (`channels`)
	 *			WHERE `id` > '2'
	 *			AND `userId` = '6'
	 *			AND `userId` = '12'
	 *			AND `uniqId` IS NOT NULL
	 *			OR `uniqId` IS NOT NULL
	 *			AND `name` LIKE '%esss%' OR `name` NOT LIKE '%deee%' OR `name` = 'test' )
	 *			AND `addDate` BETWEEN '1296561460' AND '1296727844'
	 *			OR `embedCode` NOT LIKE '%embed code%'
	 *			OR `isOnline` = '1'
	 *			OR `users`.`name` LIKE '%jhon%'
	 *			GROUP BY `category_id`
	 *			ORDER BY `id` ASC
	 * EX: 2.
	 * RESULT: SELECT (`channel`.`id` as channels_id,  ...  `users`.`id` as users_id ....)
	 *			INNER JOIN `users` ON `users`.`id` = `channels`.`user_id`
	 *			FROM (`channels`)
	 *			WHERE `id` > '2'
	 *			AND `userId` = '6'
	 *			AND `userId` = '12'
	 *			AND `uniqId` IS NOT NULL
	 *			OR `uniqId` IS NOT NULL
	 *			AND `name` LIKE '%esss%' OR `name` NOT LIKE '%deee%' OR `name` = 'test' )
	 *			AND `addDate` BETWEEN '1296561460' AND '1296727844'
	 *			OR `embedCode` NOT LIKE '%embed code%'
	 *			OR `isOnline` = '1'
	 *			OR `users`.`name` LIKE '%jhon%'
	 *			GROUP BY `category_id`
	 *			ORDER BY `id` ASC
	 *
	 *
	 * Example count:
	 *
	 *	$this->channels->get_all(array(), TRUE);
	 *
	 *  return integer
	 *
	 * Examples:
	 *
	 *  $this->channels->get_all(array('sum'=>'id'))
	 *  $this->channels->get_all(array('avg'=>'id'))
	 *  $this->channels->get_all(array('min'=>'id'))
	 *  $this->channels->get_all(array('max'=>'id'))
	 *
	 *	return integer
	 */
	
	public function get_all($filters = FALSE, $count = FALSE, $order = FALSE, $offset = FALSE, $limit = FALSE){
		
		
		$select = '';
		$use_table = $this->table;
		$offset = (int)$offset;
		$limit = (int)$limit;
		$count = (bool)$count;
		if(!$order){
			$order = 'id asc';
		}

		if($count){
			$filters['count'] = true;
		}
		
		//set select and joins for query by filters
		$filters = $this->set_select_and_joins($filters);

		//$conditions = array('<=','>=','<','>','IS NULL','IS NOT NULL', 'OR', 'AND');
		if(is_array($filters) && count($filters) > 0){
			foreach($filters as $column => $value){
				
				//check if is specify table and if exist join with this table, if not set default table.
				if(preg_match('/\./', $column)){
					list($table, $column) = explode('.', $column);
					if(!in_array($table, $this->join_table) && $table != $this->table){
						$table = $this->table;
					}
					
				}else{
					$table = $this->table;
				}
				
				//if column is in field list for this table
				if(in_array($column, $this->fields[$table])){
					
					if(is_array($value) && count($value) > 0){
						foreach($value as $key => $val){
							if($key == 'BETWEEN' && is_array($val) && count($val) == 2){
								
								$this->db->where($table.'.'.$column.' >', $val[0]);
								$this->db->where($table.'.'.$column.' <', $val[1]);
							}elseif(is_array($val) && count($val) > 0){
								foreach($val as $v){
									$this->set_wheres($table, $column, $value);
								}
							}
						}
					}else{
						
						$this->set_wheres($table, $column, $value);
					}
				}//end if
			}//end foreach
		}//end if
		
		
		if(isset($filters['group_by'])){
			
			$column = $filters['group_by'];
			
			if(preg_match('/\./',$column)){
				list($table, $column) = explode('.', $column);
			}else{
				$table = $this->table;
			}
			
			if(is_array($this->fields[$table]) && in_array($column, $this->fields[$table])){
				$this->db->group_by($table.'.'.$column);
			}
		}
		
		
		if($order == 'RAND()'){
			$this->db->order_by($order);
		}else{
			if(preg_match('/\s/', $order)){
				
				list($column, $type) = explode(' ', $order, 2);
				
				$CI = &get_instance();
				//hook by baidoc
				if(isset($CI->ignore_rest)){
					//$this->db->order_by($column,$type);
				} else {				

					if(preg_match('/\./', $column)){
						list($table, $column) = explode('.', $column, 2);
					}else{
						$table = $this->table;
					}
					
					
					if(!in_array($table, $this->join_table)){
						$table = $this->table; 
					}
					
					 //if column exist in Db in this table
					if(in_array($column, $this->fields[$table])){
						$column= $table.'.'.$column;
						$this->db->order_by($column,  $type);
					}
				}
			}
		}

		
		if($offset > 0){
			$this->db->offset($offset);
		}
		
		if($limit > 0){
			$this->db->limit($limit);
		}
		
		
		
		if($this->return_nr){
			$this->return_nr = false;
			return $this->db->get($this->table)->row()->total;
		}
		
		return $this->db->get($this->table)->result();
		
		
	}
	
	
	
	
	
	private function set_select_and_joins($filters){
		if(is_array($filters) && count($filters) > 0){
		
			$avaiable_select = array('sum', 'avg', 'min', 'max');
			foreach($avaiable_select as $select_type){
				if(isset($filters[$select_type])){

					//if column exist in table set select with condition
					if(in_array($filters[$select_type], $this->fields)){
						$select = 'select_'.$select_type;
						$this->db->$select($filters[$select_type], 'total');
						$this->return_nr = true;
					}
				}	
			}
			
			if(isset($filters['count']) && $filters['count'] == true){
				$this->db->select('count('.$this->table.'.'.$this->fields[$this->table][0].') as total');
				$this->return_nr = true;
			}


			if(isset($filters['join'])){
				//check if join index is array
				if(is_array($filters['join']) && count($filters['join']) > 0){

					//put the table name like prefix for columns from parent table
					foreach($this->fields[$this->table] as $column){
						$this->db->select($this->table.'.'.$column.' as '.$this->table.'_'.$column);
					}

					foreach($filters['join'] as $join_table => $join_conditions){
						
						//check if join table exist
						if($this->table_exist($join_table)){
							

							$this->get_fields($join_table);
							$this->join_table[]			= $join_table;

							//check if exist join option and set it.
							if(preg_match('/\,/', $join_conditions)){

								list($join, $join_option) = explode(',', $join_conditions, 2);
								$join_option = trim($join_option);

							}else{

								$join = $join_conditions;
								$join_option = $this->default_join_option;

							}

							if(preg_match('/\=/', $join_conditions)){
								
								
								
								//explode columns conditions
								list($join_column, $parent_column ) = explode('=', $join, 2);
								$parent_column = trim($parent_column);
								$join_column = trim($join_column);

								if(preg_match('/\./', $parent_column)){
									$parent_column = explode('.', $parent_column);
									$parent_column = $parent_column[1];
								}

								if(preg_match('/\./', $join_column)){
									list($table, $join_column) = explode('.', $join_column, 2);
								}else{
									$table = $join_table;
								}
								if(in_array($table, $this->join_table) && in_array($join_column, $this->fields[$table])){
									$this->db->join($table, $table.'.'.$join_column.' = '.$this->table.'.'.$parent_column, $join_option);

									//put the table name like prefix for columns
									foreach($this->fields[$join_table] as $column){
										$this->db->select($join_table.'.'.$column.' as '.$join_table.'_'.$column);
									}//end foreach


								}//end if
							}//end if
						}//end if
					}//end foreach
				}//end if
			}//end if

			foreach($filters as $key => $filter){
				if(in_array($key, $avaiable_select) || $key == 'join' || $key = 'count'){
					unset($filters[$key]);
				}
			}
		}//end if
		
		return $filters;
		
	}
	
	
	private function set_wheres($table, $column, $value){
		
		if(preg_match($this->whereConditions, $value, $condition)){
				$condition = $condition[0];
				$value = preg_replace($this->whereConditions, '', $value);
				if($condition == 'IS NULL' || $condition == 'IS NOT NULL'){

					$this->db->where($table.'.'.$column.' '.$condition);

				}elseif($condition == 'OR IS NOT NULL' || $condition == 'OR IS NULL'){

					$condition= preg_replace('/(OR\s)/', '', $condition);	

					$this->db->or_where($table.'.'.$column.' '.$condition);

				}elseif($key = array_search($condition, $this->where_types)){

					$this->db->$key($table.'.'.$column, $value);

				}else{

					$this->db->where($table.'.'.$column.' '.$condition, $value);
				}

			}else{
				$this->db->where($table.'.'.$column, $value);
			}
	}
	
	
	
	
	/**
	 *
	 * @param array $filters	$filters['column'] = 'value';
	 * @param boolean $count    Return number of total results
	 * @param string $order     
	 * @param integer $offset
	 * @param integere $limit
	 * @return mixed  array or integer
	 *
	 *
	 * Exemple:
	 *	$this->load->model('channels');
	 * $filters = array(
	 *					'id' => '> 2',
	 *					'userId' => array(
	 *								'6',
	 *								'12'
	 *							),
	 *					'uniqId' => 'IS NOT NULL',
	 *					'name' => 'example_name',
	 *					'addDate' =>array(
	 *								'BETWEEN'=>array('1296561460', '1296727844')
	 *								),
	 *					'name' => array(
	 *								'OR' =>array(
	 *											'LIKE esss', 'NOT LIKE deee', 'test'
	 *										)
	 *								),
	 *					'embedCode' => array(
	 *									'OR' => array( 'NOT LIKE embed code' )
	 *								),
	 *					'isOnline' => 'OR 1',
	 *					'join' => array('users' => 'id = user_id, inner') //view ex. 2
	 * 
	 *			);
	 *
	 *
	 *	$this->channels ->getAll($filters);
	 *
	 * EX: 1.
	 * RESULT: SELECT *
	 *			FROM (`channels`)
	 *			WHERE `id` > '2'
	 *			AND `userId` = '6'
	 *			AND `userId` = '12'
	 *			AND `uniqId` IS NOT NULL
	 *			AND ( `name` LIKE '%esss%' OR `name` NOT LIKE '%deee%' OR `name` = 'test' )
	 *			AND `addDate` BETWEEN '1296561460' AND '1296727844'
	 *			OR `embedCode` NOT LIKE '%embed code%'
	 *			OR `isOnline` = '1'
	 *			ORDER BY `id` ASC
	 * EX: 2.
	 * RESULT: SELECT (`channel`.`id` as channels_id,  ...  `users`.`id` as users_id ....)
	 *			INNER JOIN `users` ON `users`.`id` = `channels`.`user_id`
	 *			FROM (`channels`)
	 *			WHERE `id` > '2'
	 *			AND `userId` = '6'
	 *			AND `userId` = '12'
	 *			AND `uniqId` IS NOT NULL
	 *			AND ( `name` LIKE '%esss%' OR `name` NOT LIKE '%deee%' OR `name` = 'test' )
	 *			AND `addDate` BETWEEN '1296561460' AND '1296727844'
	 *			OR `embedCode` NOT LIKE '%embed code%'
	 *			OR `isOnline` = '1'
	 *			ORDER BY `id` ASC
	 *
	 *
	 *
	 * Example count:
	 *
	 *	$this->channels->getAll(array(), TRUE);
	 *
	 *  return integer
	 *
	 * Example SUM:
	 *
	 *  $this->channels->getAll(array('sum'=>'id'))
	 *
	 *	return integer
	 */
	public function __DEPRECATED__getAll($filters = FALSE, $count = FALSE, $order = FALSE, $offset = FALSE, $limit = FALSE){
		
		
		
		if(!$order){
			$order = 'id ASC';
		}
		
		$select = '';
		$use_table = $this->table;
		$offset = (int)$offset;
		$limit = (int)$limit;
		$count = (bool)$count;

		$whereConditions = '/(<=\s|>=\s|<\s|>\s|IS NULL|IS NOT NULL)/';

		if($count){
			$this->db->select('count('.$this->table.'.id) as total');
			
		}elseif(isset($filters['sum'])){
			$selectCondition = '';
			
			if(preg_match('/\./', $filters['sum'])){
				$join_sum_table_and_column = explode('.', $filters['sum']);
				
				if(count($join_sum_table_and_column) == 2 ){
					if($join_sum_table_and_column[0] == $this->join_table){
						$sum_use_table = $join_sum_table_and_column[0];
					
						if(in_array($join_sum_table_and_column[1], $this->join_table_fields)){
							$sum_column = $join_sum_table_and_column[1];
						
							if(isset($sum_use_table) && isset($sum_column)){
								$selectCondition = 'SUM('.$sum_use_table.'.'.$sum_column.') as sum_'.$sum_column;
							}
						}
					}
				}
				


			}elseif(in_array($filters['sum'], $this->fields)){
				$selectCondition = 'SUM('.$this->table.'.'.$filters['sum'].') as total';
			}
			$select = $selectCondition;
			
		}else{
			$select = '';
		}
		
		
		if(isset($filters['join'])){
			
			
			//check if join index is array
			if(is_array($filters['join']) && count($filters['join']) > 0){
				foreach($filters['join'] as $this->join_table => $join_conditions){
					
					
					//check if join table exist
					if($this->table_exist($this->join_table)){
						
						
						
						//explode columns conditions
						$join_conditions_columns = explode('=', $join_conditions);
						
						//check if conditions is ok and is between two columns
						if(is_array($join_conditions_columns) && count($join_conditions_columns) == 2){
							
							$join_conditions_columns[0] = trim($join_conditions_columns[0]);
							$join_conditions_columns[1] = trim($join_conditions_columns[1]);
							
							if(preg_match('/\,/', $join_conditions_columns[1])){
								$join_conditions_last_column_and_options = explode(',', $join_conditions_columns[1]);
								
								$join_conditions_columns[1] = trim($join_conditions_last_column_and_options[0]);

								$join_option = trim($join_conditions_last_column_and_options[1]);
								if(in_array($join_option, $this->join_options)){
									$this->default_join_option = $join_option;
								}

								
							}
							
							//get fields for join table
							$this->join_table_fields = $this->get_fields($this->join_table, TRUE);
							if(!isset($select)){
								$select = '';
							}else{
								$select = $select.', ';
							}
							foreach($this->fields as $parent_field){
								$select .= $this->table.'.'.$parent_field.' as '.$this->table.'_'.$parent_field.',';
							}
							
							foreach($this->join_table_fields as $join_field){
								$select .= $this->join_table.'.'.$join_field.' as '.$this->join_table.'_'.$join_field.',';
							}
							
							$select = substr($select, 0, -1);
							
							$this->db->select($select);
							//check if join column exist in join table and second column in parent table
							if(in_array($join_conditions_columns[0], $this->join_table_fields) && in_array($join_conditions_columns[1], $this->fields)){
								$this->db->join($this->join_table, $this->join_table.'.'.$join_conditions_columns[0].' = '.$this->table.'.'.$join_conditions_columns[1], $this->default_join_option);
							}
						}
						
					}
				}
			}
		}else{
			$this->db->select($select);
		}

		//filters must be array
		if(is_array($filters) && count($filters) > 0){

			 foreach ($filters as $column => $value ){

				 //if value is array
				 if(is_array($value)){
					 
					if(preg_match('/\./', $column)){
						$table_and_column = explode('.', $column);
						
						if(count($table_and_column) == 2 ){
							if($table_and_column[0] == $this->table || $table_and_column[0] == $this->join_table){
								$use_table = $table_and_column[0];
							}

							$column = $table_and_column[1];
						}
					}
					 //if column exist in Db in this table
					if(in_array($column, $this->fields) || in_array($column, $this->join_table_fields)){
						
						$column = $use_table.'.'.$column;
						
						// $hey is used for BETTWEN, OR conditions
						foreach ($value as $key => $conditionWithValue){

							if(is_array($conditionWithValue)){

								//For betwen condition must have only 2 values
								if($key == 'BETWEEN' && count($conditionWithValue) == 2){
									$this->db->where("`".$column."` BETWEEN '".$conditionWithValue[0]."' AND '".$conditionWithValue[1]."'");
								}


								if($key == 'OR'){
									if(count($conditionWithValue) > 1){
										$group = TRUE;
									}else{
										$group = FALSE;
									}
									$i = 0;
									$end = (count($conditionWithValue)-1); // get last element nr

									foreach($conditionWithValue as $value){

										//if value include one of this condition  (<, >, <=, =>, IS NULL, IS NOT NULL)
										if(preg_match($whereConditions, $value, $matches)){

											$value = mysql_real_escape_string(trim(preg_replace('/('.$matches[0].')/', '', $value)));
											$condition = $matches[0];

											if($i == 0 && $group === TRUE){

												//if array contain more than 1 element and that is first elemnt adding "(" and condition "AND" before "("
												$this->db->where("( `".$column."` ".$condition." '".$value."'");

											}elseif($i == $end && $group === TRUE){

												//if this is last element from array , close grou with ")"
												$this->db->or_where("`".$column."` ".$condition." '".$value."' )");

											}else{

												// Put the condition with "OR"
												$this->db->or_where("`".$column." ".$condition." '".$value."'");

											}
										//if value contain condition "NOT LIKE"
										}elseif(preg_match('/(NOT LIKE)/', $value)){

											//remove "NOT LIKE" from value
											$value = mysql_real_escape_string(trim(preg_replace('/(NOT LIKE)/', '', $value)));

											if($i == 0 && $group === TRUE){

												//if array contain more than 1 element and that is first elemnt adding "(" and condition "AND" before "("
												$this->db->where("( `".$column."` NOT LIKE '%".$value."%'");

											}elseif($i == $end && $group === TRUE){

												//if this is last element from array , close grou with ")"
												$this->db->or_where("`".$column." NOT LIKE  '%".$value."%' )");

											}else{

												// Put the condition with "OR"
												$this->db->or_where("`".$column." NOT LIKE  '%".$value."%'");
											}
										//if value contain condition "LIKE"
										}elseif(preg_match('/(LIKE\s)/', $value)){

											//remove condition "LIKE" from value
											$value = mysql_real_escape_string(trim(preg_replace('/(LIKE\s)/', '', $value)));

											if($i == 0 && $group === TRUE){
												//if array contain more than 1 element and that is first elemnt adding "(" and condition "AND" before "("
												$this->db->where("( `".$column."` LIKE '%".$value."%'");

											}elseif($i == $end && $group === TRUE){

												//if this is last element from array , close grou with ")"
												$this->db->or_where("`".$column."` LIKE '%".$value."%' )");

											}else{
												// Put the condition with OR
												$this->db->or_where("`".$column."` LIKE '%".$value."%'");
											}


										// else value dont have special condition
										}else{

											if($i == 0 && $group === TRUE){
												//if array contain more than 1 element and that is first elemnt adding "(" and condition "AND" before "("
												$this->db->where("( `".$column."` = '".$value."'");

											}elseif($i == $end && $group === TRUE){

												//if this is last element from array , close grou with ")"
												$this->db->or_where("`".$column."` = '".$value."' )");

											}else{
												// Put the condition with OR
												$this->db->or_where("`".$column."` = '".$value."'");
											}
										}
										$i++;
									}
								}
							}else{

								//if value include one of this condition  (<, >, <=, =>, IS NULL, IS NOT NULL)
								if(preg_match($whereConditions, $conditionWithValue, $matches)){

									$conditionWithValue = mysql_real_escape_string(trim(preg_replace('/('.$matches[0].')/', '', $conditionWithValue)));
									$condition = $matches[0];
									if($conditionWithValue){
										$conditionWithValue = "'".$conditionWithValue."'";
									}
									$this->db->where("`".$column."` ".$condition." ".$conditionWithValue);

								//if value contain condition "NOT LIKE"
								}elseif(preg_match('/(NOT LIKE)/', $conditionWithValue)){
									$conditionWithValue = trim(preg_replace('/(NOT LIKE)/', '', $conditionWithValue));
									$this->db->not_like($column, $conditionWithValue);

								//if value contain condition "LIKE"
								}elseif(preg_match('/(LIKE\s)/', $conditionWithValue)){
									$conditionWithValue = trim(preg_replace('/(LIKE\s)/', '', $conditionWithValue));
									$this->db->like($column, $conditionWithValue);

								//if value contain condition "OR"
								}elseif(preg_match('/(OR\s)/', $conditionWithValue)){
									$conditionWithValue = trim(preg_replace('/(OR\s)/', '', $conditionWithValue));
									$this->db->or_where($column, $conditionWithValue);

								//else value dont have special condition
								}else{
									$this->db->where($column, $conditionWithValue);
								}

								
							}
						}
					}
				 }else{
					if(preg_match('/\./', $column)){
						$table_and_column = explode('.', $column);
						
						if(count($table_and_column) == 2 ){
							if($table_and_column[0] == $this->table || $table_and_column[0] == $this->join_table){
								$use_table = $table_and_column[0];
							}

							$column = $table_and_column[1];
						}
					}
					 //if column exist in Db in this table
					if(in_array($column, $this->fields) || in_array($column, $this->join_table_fields)){
						
						$column = $use_table.'.'.$column;
						
						 if(preg_match($whereConditions, $value, $matches)){
								
							$value = mysql_real_escape_string(trim(preg_replace('/('.$matches[0].')/', '', $value)));
							$condition = $matches[0];

							if($value){
								$value = "'".$value."'";
							}

							$this->db->where("`".$column."` ".$condition." ".$value);

						 //if value contain condition "NOT LIKE"
						 }elseif(preg_match('/(NOT LIKE)/', $value)){
							$value = trim(preg_replace('/(NOT LIKE)/', '', $value));
							$this->db->not_like($column, $value);

						//if value contain condition "LIKE"
						}elseif(preg_match('/(LIKE\s)/', $value)){
							$value = trim(preg_replace('/(LIKE\s)/', '', $value));
							$this->db->like($column, $value);

						//if value contain condition "OR"
						}elseif(preg_match('/(OR\s)/', $value)){
							$value = trim(preg_replace('/(OR\s)/', '', $value));
							$this->db->or_where($column, $value);

						//else value dont have special condition
						}else{
							$this->db->where($column, $value);
						 }
					}
				 }
			 }
		}
		if($order == 'RAND()'){
			$this->db->order_by($order);
		}else{
			$orderConditions = explode(' ', $order);
			
			$column = $orderConditions[0];
			
			
			if(preg_match('/\./', $column)){
				$table_and_column = explode('.', $column);
				
				if(count($table_and_column) == 2 ){
					if($table_and_column[0] == $this->table || $table_and_column[0] == $this->join_table){
						$use_table = $table_and_column[0];
					}

					$column = $table_and_column[1];
				}
			}
			 //if column exist in Db in this table
			if(in_array($column, $this->fields) || in_array($column, $this->join_table_fields)){
				$order = $use_table.'.'.$column;
				$this->db->order_by($order,  $orderConditions[1]);
			}
		}

		if($limit){
			$this->db->offset($offset);
			$this->db->limit($limit);
		}
		

		if($count){

			return $this->db->get($this->table)->row()->total;

		}elseif(isset($filters['sum'])){

			if(!isset($filters['join'])){
				return $this->db->get($this->table)->row()->total;
			}else{
				return $this->db->get($this->table)->result();
			}

		}else{

			return $this->db->get($this->table)->result();
		}


	}
	
	

	

}
